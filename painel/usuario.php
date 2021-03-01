<?php 
session_start();
$pagina = "Usuario";
require_once '../init.php';
// Recebe o número da página via parâmetro na URL:  
$pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
// Calcula a linha inicial da consulta:
$linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Gerenciar Usuarios</title>
  </head>
  <body>
    <center>
        <?php // Verificar se o usuario está logado e se é o administrador:
        if (loggedin() && $_SESSION['usuario_adm'] == 1){
            require 'usuario-function.php';?>
            <hr><h2>Gerenciar Usuarios no sistema:</h2><hr>
            <div class="container">
                <?php // Opção para exibir o formulario de cadastro de usuario:
                if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "cadastro"){ ?> 
                    <h3>Cadastrar Usuario no sistema:</h3>
                    <div class="container">
                        <form action="?act=cadastrar" method="post" name="cadastro">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" minlength="1" class="form-control" id="exampleInputEmail1" placeholder="Digite o nome">
                            </div>
                            <div class="form-group">
                                <label for="emai1">E-mail</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Digite o e-mail">
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" name="senha" minlength="5" maxlength="10" class="form-control" id="exampleInputPassword1" placeholder="Digite a senha (De 5 a 10 caracteres)">
                            </div>
                            <input type="submit" value="Cadastrar"  class="btn btn-primary">
                            <input type="reset" value="Limpar" class="btn btn-secondary"/>
                        </form>
                    </div>
                <?php } else {
                    // Exibi o formulario de alterar usuario:
                    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "alterar"){ ?> 
                        <h3>Alterar dados do Usuario no sistema:</h3>
                        <div class="container">
                            <form action="?act=cadastrar" method="post" name="cadastro">
                                <input type="hidden" name="id" <?php
                                // Guarda o ID para envia durante o metodo POST:
                                if (isset($id) && $id != null || $id != "") {
                                    echo "value=\"{$id}\"";
                                }?> />
                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" minlength="1" class="form-control"<?php
                                    // Preenche automaticamente o campo nome com o valor já cadastrado:
                                    if (isset($nome) && $nome != null || $nome != ""){
                                    echo "value=\"{$nome}\"";
                                    }?> />
                                </div>
                                <div class="form-group">
                                    <label for="emai1">E-mail</label>
                                    <input type="email" name="email" class="form-control"<?php
                                    // Preenche automaticamente o campo email com o valor já cadastrado:
                                    if (isset($email) && $email != null || $email != ""){
                                    echo "value=\"{$email}\"";
                                    }?> />
                                </div>
                                <div class="form-group">
                                    <label for="senha">Senha</label>
                                    <input type="password" name="senha" minlength="5" maxlength="10" class="form-control" id="exampleInputPassword1" placeholder="Digite a senha (De 5 a 10 caracteres)">
                                </div>
                                <input type="submit" value="Cadastrar"  class="btn btn-primary">
                                <input type="reset" value="Limpar" class="btn btn-secondary"/>
                            </form>
                        </div>
                    <?php } ?>
                    <form action="?act=cadastro" method="POST" name="formB1" >
                        <hr><input type="submit" value="Cadastrar Usuario" class="btn btn-info"/></hr><br>
                    </form>
                <?php } ?>
            </div>
            <hr/>
            <!-- Exibe a lista de usuarios cadatrados: -->
            <div class="container">
                <h3>Lista de Usuarios cadastrados</h3>
                <table width='100%' >
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Opções</th>
                    </tr>
                    <?php // Chama a função de paginação:
                    require_once '../paginacao-function.php'; 
                    foreach($dados as $rs): ?> 
                            <?php echo "<td>".$rs->usuario_nm."</td><td>".$rs->usuario_email."</td></td>"?>
                            <td>
                                <a href=?act=alterar&id=<?=$rs->usuario_id;?>><button type="button" class="btn btn-success">[Alterar]</button></a>
                                <a href=?act=excluir&id=<?=$rs->usuario_id?>><button type="button" class="btn btn-danger">[Excluir]</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php
                // Botões da paginação:
                require '../paginacao-buttons.php';?>
            </div>
            <?php // Se o usuario não estiver logado ou se não for o administrador:
            } ?>
            <br><a class="btn btn-secondary" href="../index.php" role="button">Voltar para a Home</a>
    </center>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>