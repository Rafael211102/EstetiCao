<?php
include("conectadb.php");
session_start();
 
 
 

// Consulta para lista de clientes
$sqlcli = "SELECT cli_id, cli_nome FROM tb_clientes";
$retornocli = mysqli_query($link, $sqlcli);

// Consulta para lista de serviços
$sqlservicos = "SELECT serv_id, serv_nome FROM tb_servicos";
$retornoservicos = mysqli_query($link, $sqlservicos);
 
// TRAZ LISTA DE QUADRAS RESERVADAS
$sql_servicos = "SELECT serv_nome FROM tb_servicos";
$resultado_servicos = mysqli_query($link, $sql_servicos);
?>
 
 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Reserva</title>
</head>
<body>
    <div class="container-global">
        <!-- Formulário para adicionar uma reserva -->
        <form class="formulario" action="agenda.php" method="post">
            <!-- Selecionar Serviço -->
            <label for="servico">Selecione o Serviço</label>
            <select name="servico" id="servico" required>
                <?php while ($servico = mysqli_fetch_array($retornoservicos)) { ?>
                    <option value="<?= $servico['serv_id'] ?>"><?= strtoupper($servico['serv_nome']) ?></option>
                <?php } ?>
            </select>
            <br>
            
            <!-- Selecionar Data -->
            <label for="dia">Dia</label>
            <input type="date" name="dia" id="dia" min="<?= date('Y-m-d'); ?>" required>
            <br>

            <input type="submit" value="Confirmar">
        </form>
    </div>
</body>
</html>
