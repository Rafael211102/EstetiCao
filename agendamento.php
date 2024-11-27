<?php 
include("conectadb.php");

// Variáveis para armazenar dados
$servicos = [];
$horarios_disponiveis = [];
$preco = 0;
$idservicos = null;

// Consulta para obter os serviços
$sql_servicos = "SELECT serv_id, serv_nome, serv_preco FROM tb_servicos";
$result_servicos = mysqli_query($link, $sql_servicos);

if ($result_servicos) {
    while ($row = mysqli_fetch_assoc($result_servicos)) {
        $servicos[] = $row;
    }
}

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idservicos = $_POST['servico'];
    $data = $_POST['data'];

    // Recuperar preço do serviço selecionado
    $sql_preco = "SELECT serv_preco FROM tb_servicos WHERE serv_id = ?";
    $stmt = mysqli_prepare($link, $sql_preco);
    mysqli_stmt_bind_param($stmt, "i", $idservicos);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $preco);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Aqui você pode implementar a lógica para buscar horários disponíveis para a data selecionada
    // Para este exemplo, vou usar um array de horários fixos
    $horarios_disponiveis = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00']; // Exemplo de horários disponíveis
}

// Se os detalhes do agendamento forem confirmados
if (isset($_GET['confirmar'])) {
    $horario = $_GET['horario'];

    // Verifique se os parâmetros estão definidos
    if ($idservicos && $data && $horario) {
        // Redirecionar para a página de finalização
        header("Location: reserva-finalizar.php?servico=$idservicos&data=$data&horario=$horario&preco=$preco");
        exit();
    } else {
        echo "<script>alert('Erro: Informações não recebidas.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formulario.css">
    <title>Agendamento</title>
</head>
<body>
    <div class="box">
        <fieldset>
            <form class="formulario" action="agendamento.php" method="post">
                <legend><b>Agendar Serviço</b></legend>
                
                <div class="inputBox">
                    <label for="servico">Selecione o Serviço:</label>
                    <select name="servico" id="servico" required onchange="this.form.submit()">
                        <option value="">Selecione...</option>
                        <?php foreach ($servicos as $servico) { ?>
                            <option value="<?= $servico['serv_id'] ?>" <?= $idservicos == $servico['serv_id'] ? 'selected' : '' ?>><?= $servico['serv_nome'] ?> - R$ <?= number_format($servico['serv_preco'], 2, ',', '.') ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="inputBox">
                    <label for="data">Data:</label>
                    <input type="date" name="data" id="data" value="<?= isset($_POST['data']) ? $_POST['data'] : '' ?>" required>
                </div>
                
                <div class="inputBox">
                    <label for="horario">Horário:</label>
                    <select name="horario" id="horario" required>
                        <option value="">Selecione um horário...</option>
                        <?php if (!empty($horarios_disponiveis)): ?>
                            <?php foreach ($horarios_disponiveis as $horario): ?>
                                <option value="<?= $horario ?>"><?= $horario ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <?php if (!empty($idservicos) && !empty($horarios_disponiveis)): ?>
                    <div class="resumo">
                        <p><strong>Resumo do Agendamento:</strong></p>
                        <p>Serviço: <?= $servicos[array_search($idservicos, array_column($servicos, 'serv_id'))]['serv_nome'] ?></p>
                        <p>Data: <?= isset($_POST['data']) ? $_POST['data'] : '' ?></p>
                        <p>Horário: <span id="horario-selecionado"></span></p>
                        <p>Preço: R$ <?= number_format($preco, 2, ',', '.') ?></p>
                        <a href="agendamento.php?confirmar=true&horario=" id="confirmar-btn" onclick="event.preventDefault(); confirmAgendamento()">Confirmar Agendamento</a>
                    </div>
                <?php endif; ?>

                <input type="submit" value="Confirmar Agendamento">
            </form>
        </fieldset>
    </div>

    <script>
        function confirmAgendamento() {
            const horario = document.getElementById('horario').value;
            const servico = document.getElementById('servico').value;
            const data = document.getElementById('data').value;

            if (horario && servico && data) {
                window.location.href = `agendamento.php?confirmar=true&horario=${horario}&servico=${servico}&data=${data}`;
            } else {
                alert('Por favor, preencha todos os campos antes de confirmar.');
            }
        }

        document.getElementById('horario').addEventListener('change', function() {
            document.getElementById('horario-selecionado').innerText = this.value;
        });
    </script>
</body>
</html>
