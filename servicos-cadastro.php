<?php
include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nomeservico = $_POST[ 'txtnome' ];
    $descricao = $_POST['txtdescricao'];
    $duracao = $_POST['txtduracao'];
    $preco = $_POST['txtpreco'];



    // Verificar se o produto existe
    $sql = "SELECT COUNT(serv_id) FROM tb_servicos WHERE serv_nome = '$nomeservico'";
    
    $retorno = mysqli_query($link, $sql);
    $contagem = mysqli_fetch_array($retorno) [0];

    if($contagem == 0){
       
        $sql = "INSERT INTO tb_servicos(serv_nome, serv_descricao, serv_duracao, serv_preco)

        VALUES ('$nomeservico', '$descricao', '$duracao', $preco)";
        
        $retorno = mysqli_query($link, $sql);

        echo"<script>window.alert('SERVIÇO CADASTRADO');</script>";
        echo"<script>window.location.href='servico-lista.php';</script>";
    }
    else{
        echo"<script>window.alert('SERVIÇO JÁ EXISTENTE!!');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <script src="./javaScript.js"></script>
    <link rel="shortcut icon" href="./icons/logo-icon.ico" type="image/x-icon">
    <title>Cadastro produtos</title>
</head>

<header>
<?php
// session_start();
// $nomeusuario = $_SESSION['nomeusuario'];
?>
<!-- 
        <div class="topo">
        <a href="./backoffice.php"><img src="img/logo.png" width="80px" height= "80px" style="margin-top: -15px;"  alt=""></a>
            <?php
            if ($nomeusuario !=NULL){
            ?>
            <li class="perfil"><label>BEM VINDO <?= strtoupper($nomeusuario)?></label></li>
            <?php
            }

            else{
                echo("<script>window.alert('USUARIO NÃO LOGADO');
                window.location.href='login.php';</script>");
            }
            ?>
                    <span style="position: relative; float: left; left: 430px; margin-top: -5px;"><a href="backoffice.php"><img src="./icons/Navigation-left-01-256.png" width="70px" height="60px"  alt="Voltar" ></a></span>
            <a href="logout.php"><img src="./icons/Exit-02-WF-256.png" width="50px" height="50px"></a>
        </div>
    
</header>
 -->
<body>
    <div class="container-global">
        <form action="servicos-cadastro.php" class="formulario" method="post" enctype="multipart/form-data">
        <img src="img/logo.png" width="150px" height= "150px"  alt="Logo Mafia do Pão">
            <label>NOME DO SERVIÇO</label>
            <input type="text" name="txtnome" placeholder="DIGITE O NOME DO SERVIÇO" required>
            <br>
            <label>DESCRIÇÃO</label>
            <input type="text" name="txtdescricao" placeholder="DIGITE A DESCRIÇAO" required>
             <br>
             <label>DURAÇÃO</label>
            <input type="number" name="txtduracao" placeholder="DIGITE A DURAÇÃO" required>
             <br>
            <label>PREÇO</label>
            <input type="decimal" name="txtpreco" placeholder="DIGITE O PREÇO" required>
            <br>
            
            <input type="submit" value="CADASTRAR SERVIÇO">
        </form>
    </div>
</body>
</html>