<?php
include("conectadb.php");

 
 
 
// TRAZ LISTA DE CLIENTES
$sqlcli = "SELECT cli_id, cli_nome FROM tb_clientes";
$retornocli = mysqli_query($link, $sqlcli);
 
// TRAZ LISTA DE QUADRAS PARA RESERVA
$sqlservicos = "SELECT * FROM tb_servicos";
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
    <title>RESERVA</title>
</head>
 
<body>
    <div class="container-global">
 
    <!-- Formulário para adicionar uma reserva -->
    <form class="formulario" action="agenda.php" method="post">
        <!-- Selecionar cliente -->
        <label>SELECIONE O SERVIÇO</label>
        <select name='servico' id = "servico" required>
            <?php while ($tblservicos = mysqli_fetch_array($retornoservicos)) { ?>
                <option value="<?= $tblservicos[0] ?>"><?= strtoupper($tblservicos[1]) ?></option>
            <?php } ?>
        </select>
        <br>
       
 
        <!-- Selecionar data e horas -->
        <label>DIA</label>
        <input type="date" name="dia" id="dia" required>
        <br>
       
        <input type="submit" value="CONFIRMAR">
    </form>
 
    </div>
   
    <br>
 
   
 
</body>
 
</html>