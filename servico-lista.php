<?php
include('conectadb.php');


// A pagina carregou... o que ela vai fazer?

// A pesquisa no banco todos os produtos do banco
$sql = "SELECT * FROM tb_servicos";
$retorno = mysqli_query($link, $sql);
$status = '';
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <script src="./javaScript.js"></script>
    <title>LISTA DE SERVÇOS</title>
    <link rel="shortcut icon" href="./icons/logo-icon.ico" type="image/x-icon">
</head>



<body>
    
<div class="container-listausuarios">

    
        <!-- Listar tabela de produtos -->
        <table class="lista">
            <tr>
                <th>CÓDIGO</th>
                <th>NOME DO SERVIÇO</th>
                <th>DESCRIÇÃO</th>
                <th>DURAÇÃO</th>
                <th>PREÇO</th>
                
            </tr>
            
            
            <!-- BUSCAR NO BANCO OS DADOS DE TODOS OS PRODUTOS -->
            <?php
            while ($tbl = mysqli_fetch_array($retorno)) {
            ?>
                <tr>
                    <td><?= $tbl['serv_id'] ?></td> 
                    <td><?= $tbl['serv_nome'] ?></td>
                    <td><?= $tbl['serv_descricao'] ?></td> 
                    <td><?= $tbl['serv_duracao'] ?></td> 
                    <td><?= $tbl['serv_preco'] ?></td> 

                  
                </tr>
                
            <?php
            }
            ?>
        </table>
    </div>
    </body>

</html>
