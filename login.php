<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-estilo.css">
    <script src="./javaScript.js"></script>
    <title>LOGIN USUARIO</title>
    <link rel="shortcut icon" href="./icons/logo-icon.ico" type="image/x-icon">
</head>

<body>

    <div class="container-global">

        <form class="formulario" action="login.php" method="post">
            <img src="img/logo.png" width="150px" height="150px" alt="">
            <label>CPF</label>
            <br>
            <input type="number" name="txtlogin" placeholder="Login" required>
            <br>
            <label>SENHA</label>
            <br>
            <input type="password" name="txtsenha" placeholder="Senha" required>
            <br>
            <br>
            <input type="submit" value="ACESAR">
        </form>
    </div>
</body>

</html>