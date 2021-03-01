<?php 
session_start();
$pagina = "Login";
require_once '../init.php'?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
    <center>
        <?php // Verificar se o usuario não está logado:
        if (!loggedin()){
            // Se não estiver logado; exibe formulario de Login:
            require 'login-function.php';?>
            <div class="container">
                <form action="?act=login" method="post" name="login">
                    <div class="form-group">
                        <label for="emai1">E-mail</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Digite o seu e-mail">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" minlength="5" maxlength="10" class="form-control" id="exampleInputPassword1" placeholder="Digite a sua senha">
                    </div>
                    <input type="submit" value="Entrar"  class="btn btn-primary">
                </form>
                <br><a class="btn btn-success" href="cadastro.php" role="button">Não tenho conta nesse site</a><br>
            </div>
        <?php // Se o usuario estiver logado; exibe a seguinte notificação:
        } else { ?>
            <h4 class="bg-success"><b>Login efetuado com sucesso!</b></h4>
        <?php } ?>
            <br><a class="btn btn-info" href="../index.php" role="button">Voltar para a Home</a>
    </center>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>