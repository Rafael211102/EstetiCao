<?php 
session_start();
include("conectadb.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['cliente_id'])) {
    echo "<script>window.alert('Por favor, faça o login antes de agendar um serviço.');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se as variáveis necessárias estão definidas
    if (isset($_POST['servico'], $_POST['dia'], $_POST['horario'])) {
        $idservicos = $_POST['servico'];
        $data = $_POST['dia'];
        $horainicio = $_POST['horario']; // Captura a hora do formulário

        // Exibir as variáveis para debugging
        echo "Serviço: $idservicos, Data: $data, Horário: $horainicio<br>";

        // Verificando se o serviço está disponível
        $sqlverificar = "SELECT serv_disponibilidade FROM tb_servicos WHERE serv_id = ?";
        $stmt = mysqli_prepare($link, $sqlverificar);
        mysqli_stmt_bind_param($stmt, "i", $idservicos);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $disponibilidade = mysqli_fetch_array($result)[0];

        if ($disponibilidade == 0) {
            echo "<script>window.alert('SERVIÇO INDISPONÍVEL.')</script>";
            echo "<script>window.location.href='agenda.php'</script>";
            exit;
        } else {
            // Consultando o preço do serviço
            $sql = "SELECT serv_preco FROM tb_servicos WHERE serv_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "i", $idservicos);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $valortotal = mysqli_fetch_array($result)['serv_preco'];

            // Exibir o valor total para debugging
            echo "Valor Total: $valortotal<br>";

            // Inicializa o status
            $status = '1'; // Aqui está a definição do status

            // Verifica se existe uma reserva já aberta
            $sql = "SELECT COUNT(iv_status) FROM tb_reservas WHERE iv_status = 1";
            $retorno = mysqli_query($link, $sql);
            $cont = mysqli_fetch_array($retorno)[0];

            // Insere a reserva
            if ($cont == 0) {
                $codigo_reserva = md5(rand(1, 9999) . date('h:i:s'));
                $sqlitem = "INSERT INTO tb_reservas (iv_valortotal, fk_serv_id, fk_cli_id, iv_status, dia, horainicio)
                            VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sqlitem);
                mysqli_stmt_bind_param($stmt, "isssss", $valortotal, $idservicos, $_SESSION['cliente_id'], $status, $data, $horainicio);
                mysqli_stmt_execute($stmt);
            } else {
                // Se reserva existe, consulta o número da reserva para adicionar mais horas
                $sql = "SELECT iv_cod_iv FROM tb_reservas WHERE iv_status = 1";
                $reservasabertas = mysqli_query($link, $sql);
                $codigo_reserva_ok = mysqli_fetch_array($reservasabertas)[0];

                // Insere a reserva com código de reserva existente
                $sqlitem = "INSERT INTO tb_reservas (iv_valortotal, fk_serv_id, fk_cli_id, iv_status, dia, horainicio)
                            VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sqlitem);
                mysqli_stmt_bind_param($stmt, "isssss", $valortotal, $idservicos, $_SESSION['cliente_id'], $status, $data, $horainicio);
                mysqli_stmt_execute($stmt);
            }
        }
    } else {
        echo "<script>window.alert('Informações incompletas.');</script>";
        exit; // Para evitar erros adicionais
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Agendamento</title>
</head>
<body>
    <div class="container">
        <h2>Agendamento de Serviços</h2>
        <form class="formulario" action="reserva-finalizar.php" method="post">
    <input type="hidden" name="servico" value="<?= $idservicos ?>">
    <input type="hidden" name="preco" value="<?= $valortotal ?>">
    <input type="hidden" name="data" value="<?= $data ?>">
    <input type="hidden" name="horario" value="<?= isset($_POST['horario']) ? $_POST['horario'] : '' ?>">

    <label>Selecione o horário:</label>
    <select name="horario">
        <?php foreach ($horarios_disponiveis as $horario) { ?>
            <?php if (horarioEstaReservado($horario, $horarios_reservados)) { ?>
                <option value="<?php echo $horario; ?>" disabled><?php echo $horario; ?> (Indisponível)</option>
            <?php } else { ?>
                <option value="<?php echo $horario; ?>"><?php echo $horario; ?></option>
            <?php } ?>
        <?php } ?>
    </select>
    <br><br>
    <input type="submit" value="Reservar">
</form>

    </div>
</body>
</html>
