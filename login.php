<?php 
session_start();
include("conectadb.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta ao banco de dados
    $sql = "SELECT cli_id, cli_senha FROM tb_clientes WHERE cli_email = '$email'";
    $resultado = mysqli_query($link, $sql);
    
    if (mysqli_num_rows($resultado) > 0) {
        $linha = mysqli_fetch_assoc($resultado);
        
        // Verifica se a senha está correta
        if (password_verify($senha, $linha['cli_senha'])) {
            // Inicia a sessão
            $_SESSION['cliente_id'] = $linha['cli_id'];
            echo "<script>window.alert('Login bem-sucedido!');</script>";
            echo "<script>window.location.href='servicos.php';</script>";
        } else {
            echo "<script>window.alert('Senha incorreta!');</script>";
        }
    } else {
        echo "<script>window.alert('E-mail não encontrado!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formulario.css">
    <title>Login</title>
</head>
<body>
    <div class="box">
        <fieldset>
            <form class="formulario" action="login.php" method="post">
                <legend><b>Login de Clientes</b></legend>
                <div class="inputBox">
                    <label for="email" class="labelInput">E-mail</label>
                    <input type="email" name="email" id="email" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="senha" class="labelInput">Senha</label>
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                </div>
                <br>
                <input type="submit" value="Login">
            </form>
            <p>Não tem uma conta? <a href="formulario.php">Cadastre-se aqui </a></p>
        </fieldset>
    </div>
</body>
</html>
