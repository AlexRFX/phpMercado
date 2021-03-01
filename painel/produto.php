<?php 
session_start();
$pagina = "produto";
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

    <title>Gerenciar Produto</title>
  </head>
  <body>
    <center>
        <?php // Verificar se o usuario está logado e se é o administrador:
        if (loggedin() && $_SESSION['usuario_adm'] == 1){
            require 'produto-function.php';?>
            <hr><h2>Gerenciar Produtos no sistema:</h2><hr>
            <div class="container">
                <?php // Opção para exibir o formulario de cadastro de Sub-Categoria:
                if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "cadastro"){ ?> 
                    <h3>Cadastrar Produto:</h3>
                    <div class="container">
                        <form action="?act=cadastrar" method="post" name="cadastro">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" minlength="1" class="form-control" id="exampleInputEmail1" placeholder="Digite o nome">
                            </div>
                            <div>
                                <label for="categoria">Categoria:</label><br>
                                <?php if ($stmt3->execute()) { ?>
                                    <select name="categoria">
                                        <?php // Pega todas as categoriaas cadastradas para exibir como opção:
                                        while ($opt = $stmt3->fetch(PDO::FETCH_OBJ)) {
                                            if($opt->categoria_id != $categoria): ?>
                                                <option value="<?=$opt->categoria_id?>" style="width:60%;"  class="form-control input-lg"><?=$opt->categoria_nm?></option>
                                            <?php endif;
                                        }
                                }?>
                                    </select>                         
                            </div><br>
                            <div>
                                <label for="subcategoria">Sub-Categoria:</label><br>
                                <?php if ($stmt4->execute()) { ?>
                                    <select name="subcategoria">
                                        <?php // Pega todas as categoriaas cadastradas para exibir como opção:
                                        while ($opt2 = $stmt4->fetch(PDO::FETCH_OBJ)) {
                                            if($opt2->subcategoria_id != $subcategoria): ?>
                                                <option value="<?=$opt2->subcategoria_id?>" style="width:60%;"  class="form-control input-lg"><?=$opt2->subcategoria_nm?></option>
                                            <?php endif; 
                                        }
                                }?>
                                    </select>                         
                            </div><br>
                            <div class="form-group">
                                <label for="descricao">Descrição:</label>
                                <input type="text" name="descricao" minlength="1" class="form-control">
                            </div>
                            <div>
                                <label for="preco">Preço:</label><br>
                                R$<input type="decimal" required name="preco" min="0" value="0" step="any">
                            </div><br>
                            <div>
                                <label for="status">Status:</label><br>
                                <select name="status">
                                    <option value="Inativo">Inativo</option>
                                    <option value="Ativo">Ativo</option>
                                </select> 
                            </div><br>
                            <input type="submit" value="Cadastrar"  class="btn btn-primary">
                            <input type="reset" value="Limpar" class="btn btn-secondary"/>
                        </form>
                    </div>
                <?php } else {
                    // Exibi o formulario de alterar sub-categoria:
                    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "alterar"){ ?> 
                        <h3>Editar Produto:</h3>
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
                                <div>
                                    <label for="categoria">Categoria:</label><br>
                                    <?php if ($stmt3->execute()) { ?>
                                        <select name="categoria">
                                            <option value="<?=$categoria;?>"><?=optionname($optiontype = 'categoria', $categoria);?></option>
                                            <?php // Pega todas as categoriaas cadastradas para exibir como opção:
                                            while ($opt = $stmt3->fetch(PDO::FETCH_OBJ)) {
                                                if($opt->produto_categoria_fk != $categoria): ?>
                                                    <option value="<?=$opt->produto_categoria_fk?>" style="width:60%;"  class="form-control input-lg"><?=$opt->categoria_nm?></option>
                                                <?php endif; 
                                                }
                                    }?>
                                        </select>                          
                                </div><br>
                                <div>
                                    <label for="subcategoria">Categoria:</label><br>
                                    <?php if ($stmt4->execute()) { ?>
                                        <select name="subcategoria">
                                            <option value="<?=$subcategoria;?>"><?=optionname($optiontype = 'subcategoria', $subcategoria);?></option>
                                            <?php // Pega todas as categoriaas cadastradas para exibir como opção:
                                            while ($opt2 = $stmt4->fetch(PDO::FETCH_OBJ)) {
                                                if($opt2->produto_subcategoria_fk != $subcategoria): ?>
                                                    <option value="<?=$opt2->produto_subcategoria_fk?>" style="width:60%;"  class="form-control input-lg"><?=$opt2->subcategoria_nm?></option>
                                                <?php endif; 
                                                }
                                    }?>
                                        </select>                          
                                </div>
                                <div>
                                    <label for="descricao">Descrição:</label>
                                    <input type="text" name="descricao" minlength="1" class="form-control"<?php
                                    // Preenche automaticamente o campo descrição com o valor já cadastrado:
                                    if (isset($descricao) && $descricao != null || $descricao != ""){
                                        echo "value=\"{$descricao}\"";
                                    }?> />
                                </div>
                            <div>
                                <label for="preco">Preço:</label><br>
                                R$ <input type="decimal" name="preco" min="0" value="0" step="any"<?php
                                    // Preenche automaticamente o campo nome com o valor já cadastrado:
                                    if (isset($preco) && $preco != null || $preco != ""){
                                    echo "value=\"{$preco}\"";
                                    }?> />
                            </div><br>
                            <div>
                                <div>
                                    <label for="status">Status:</label><br>
                                    <select name="status">
                                        <option value="Inativo">Inativo</option>
                                        <option value="Ativo">Ativo</option>
                                    </select> 
                                </div><br>
                                <input type="submit" value="Cadastrar"  class="btn btn-primary">
                                <input type="reset" value="Limpar" class="btn btn-secondary"/>
                            </form>
                        </div>
                    <?php } ?>
                    <form action="?act=cadastro" method="POST" name="formB1" >
                        <hr><input type="submit" value="Cadastrar novo Produto" class="btn btn-info"/></hr><br>
                    </form>
                <?php } ?>
            </div>
            <hr/>
            <!-- Exibe a lista de Produtos cadatrados: -->
            <div class="container">
                <h3>Lista de Produto cadastrados</h3>
                <table width='100%' >
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Sub-Categoria</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                    <?php // Chama a função de paginação:
                    require_once '../paginacao-function.php'; 
                    foreach($dados as $rs):  
                            echo "<tr><td>".$rs->produto_nm."</td><td>".$rs->categoria_nm."</td><td>".$rs->subcategoria_nm."</td><td>".$rs->produto_status."</td>"?>
                            <td>
                                <a href=?act=alterar&id=<?=$rs->produto_id;?>><button type="button" class="btn btn-success">[Alterar]</button></a>
                                <a href=?act=excluir&id=<?=$rs->produto_id?>><button type="button" class="btn btn-danger">[Excluir]</button></a>
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