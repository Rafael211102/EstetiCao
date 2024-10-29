<?php 
include("conectadb.php");

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $genero = $_POST['genero'];
    $data_nasc = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $endereco = $_POST['endereco'];

    // VALIDA SE O USUARIO CADASTRAR EXISTE
    $sql ="SELECT COUNT(usu_id)FROM tb_clientes WHERE usu_nome = '$nome' OR usu_email = '$email'";


// RETORNO DO BANCO
$retorno = mysqli_query($link, $sql);
$contagem = mysqli_fetch_array($retorno) [0];

// VERIFICA SE USUARIO EXISTE
if($contagem == 0){
    $sql = "INSERT INTO tb_clientes(usu_nome, usu_email, usu_telefone, usu_genero, usu_nasc, usu_cidade, usu_estado, usu_endereco) VALUES('$nome', '$email', '$telefone', '$genero', '$data_nasc' , '$cidade', '$estado', '$endereco')";
    mysqli_query($link, $sql);
    echo"<script>window.alert('USARIO CADASTRADO COM SUCESSO');</script>";
    echo"<script>window.location.href='servicos.php';</script>";
}
else if($contagem >=1){
    echo"<script>window.alert('USUARIO JÁ EXISTE!');</script>";
}
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formulario.css">
    <script src="javaScript.js"></script>
    <title>Formulario</title>
</head>

<body>



    <div class="box">
    
            <fieldset>
            <form class="formulario" action="formulario.php" method="post">
                <legend><b>Formulario de Clientes</b></legend>
                <br>
                <div class="inputBox">
                    <label for="nome" class="labelInput">Nome completo</label>
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="email" class="labelInput">E-mail</label>
                    <input type="text" name="email" id="email" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="telefone" class="labelInput">Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="inputUser"  placeholder="(XX) X XXXX-XXXX" maxlength="16" oninput="formatarTelefone()" required>

                </div>

                <p>Sexo:</p>
                <input type="radio" name="genero" id="feminino" value="feminino" required>
                <label for="feminino">Feminino</label>
                <br>
                <input type="radio" name="genero" id="masculino" value="masculino" required>
                <label for="masculino">Masculino</label>
                <br>
                <input type="radio" name="genero" id="outro" value="outro" required>
                <label for="outro">Outro</label>
                <br><br>

                    <label for="data_nascimento"><b>Data de nascimento:</b></label>
                    <input type="date" name="data_nascimento" id="data_nascimento"  required>
                <br>
                <div class="inputBox">
                    <label for="cidade" class="labelInput">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>

                </div>
                <br>
                <div class="inputBox">
                    <label for="estado" class="labelInput">Estado</label>
                    <input type="text" name="estado" id="estado" class="inputUser" required>

                </div>
                <br>
                <div class="inputBox">
                    <label for="endereco" class="labelInput">Endereço</label>
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                </div>
                <br>
                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>
    </div>
</body>

</html>