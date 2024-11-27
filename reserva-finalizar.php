<?php
// Iniciar a sessão
session_start();

// Verificar se os dados foram passados
if (isset($_GET['servico']) && isset($_GET['data']) && isset($_GET['horario']) && isset($_GET['preco'])) {
    $servico = $_GET['servico'];
    $data = $_GET['data'];
    $horario = $_GET['horario'];
    $preco = $_GET['preco'];
} else {
    die("Erro: Informações não recebidas.");
}

// Consultar o nome do serviço a partir do ID
include("conectadb.php");
$sql = "SELECT serv_nome FROM tb_servicos WHERE serv_id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $servico);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $servico_nome);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalização do Agendamento</title>
</head>
<body>
    <h1>Confirmação de Agendamento</h1>
    <p><strong>Serviço:</strong> <?= htmlspecialchars($servico_nome) ?></p>
    <p><strong>Data:</strong> <?= htmlspecialchars($data) ?></p>
    <p><strong>Horário:</strong> <?= htmlspecialchars($horario) ?></p>
    <p><strong>Preço:</strong> R$ <?= htmlspecialchars(number_format($preco, 2, ',', '.')) ?></p>
    
    <p>Obrigado por agendar conosco!</p>
</body>
</html>
