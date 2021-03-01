<?php
session_start();
$pagina = "Opções";
// inclui o arquivo de inicializão:
require '../init.php';
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Opções</title>
  </head>
  <body>
    <center>
        <?php // Verifica se o usuario logado é administrador:
        if ($_SESSION['usuario_adm'] == 1) { ?>
            <br><a class="btn btn-success" href="usuario.php" role="button">Gerenciar Usuarios</a><br>
            <br><a class="btn btn-primary" href="produto.php" role="button">Gerenciar Produtos</a><br>  
            <br><a class="btn btn-info" href="categoria.php" role="button">Gerenciar Categorias</a><br>
            <br><a class="btn btn-info" href="subcategoria.php" role="button">Gerenciar Sub-Categorias</a><br>
        <?php } ?>
        <br><a class="btn btn-secondary" href="../index.php" role="button">Voltar para a Home</a>
    </center>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>