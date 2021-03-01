<?php
session_start();
$pagina = "Produtos";
// inclui o arquivo de inicializão:
require_once 'init.php';
// Recebe o número da página via parâmetro na URL:  
$pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
// Calcula a linha inicial da consulta:
$linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Produtos</title>
    </head>
    <body>
        <?php
        // Include da NavBar
        include 'navbar.php';
        
        // Verifica se o usuário está logado, se não estiver logado; envia para o formulario de login:
        if (!LoggedIn()){
            header('Location: user/login.php');
        }
        
        require 'produtos-function.php';?>
        <center>
            <h3>Buscar Produto:</h3>
                    <div class="container">
                        <form action="?act=buscar" method="post" name="buscar">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" minlength="1" class="form-control" style="width:50%;"<?php
                                // Preenche o nome no campo nome com um valor "value"
                                if (isset($nome) && $nome != null || $nome != ""){
                                    echo "value=\"{$nome}\"";
                                }?> />
                            </div>
                            <div>
                                <label for="categoria">Categoria:</label><br>
                                <?php if ($stmt1->execute()) { ?>
                                    <select name="categoria">
                                        <?php if($categoria != '*'): ?>
                                            <option value="<?=$categoria;?>"><?=optionname($optiontype = 'categoria', $categoria);?></option>
                                            <option value="*">Todas</option>
                                        <?php else: ?>
                                            <option value="*">Todas</option>
                                        <?php endif;
                                        // Pega todas as categoriaas cadastradas para exibir como opção:
                                        while ($opt = $stmt1->fetch(PDO::FETCH_OBJ)) {
                                            if($opt->categoria_id != $categoria): ?>
                                                <option value="<?=$opt->categoria_id?>" style="width:60%;"  class="form-control input-lg"><?=$opt->categoria_nm?></option>
                                            <?php endif;
                                        }
                                }?>
                                    </select>                         
                            </div><br>
                            <div>
                                <label for="subcategoria">Sub-Categoria:</label><br>
                                <?php if ($stmt2->execute()) { ?>
                                    <select name="subcategoria">
                                        <?php if($subcategoria != '*'): ?>
                                            <option value="<?=$subcategoria;?>"><?=optionname($optiontype = 'subcategoria', $subcategoria);?></option>
                                            <option value="*">Todas</option>
                                        <?php else: ?>
                                            <option value="*">Todas</option>
                                        <?php endif;
                                        // Pega todas as categoriaas cadastradas para exibir como opção:
                                        while ($opt2 = $stmt2->fetch(PDO::FETCH_OBJ)) {
                                            if($opt2->subcategoria_id != $subcategoria): ?>
                                                <option value="<?=$opt2->subcategoria_id?>" style="width:60%;"  class="form-control input-lg"><?=$opt2->subcategoria_nm?></option>
                                            <?php endif; 
                                        }
                                }?>
                                    </select>                         
                            </div><br>
                            <input type="submit" value="Buscar"  class="btn btn-primary">
                        </form>
                    </div>
                <hr/>
            <!-- Exibe a lista de Produtos cadatrados: -->
            <div class="container">
                <h3>Lista de Produtos</h3>
                <table width='100%' >
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Sub-Categoria</th>
                        <th>Preço (R$)</th>
                    </tr>
                    <?php // Chama a função de paginação:
                    require_once 'paginacao-function.php'; 
                    foreach($dados as $rs):  
                            echo "<tr><td>".$rs->produto_nm."</td><td>".$rs->categoria_nm."</td><td>".$rs->subcategoria_nm."</td><td>R$ ".$rs->produto_preco."</td>"?>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php
                // Botões da paginação:
                require 'paginacao-buttons.php';?>
            </div>
    </center>
    </body>
</html>
