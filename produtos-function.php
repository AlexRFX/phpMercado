<?php 
// Verifica se algum dado foi envia através do metodo POST:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $categoria = (isset($_POST["categoria"]) && $_POST["categoria"] != null) ? $_POST["categoria"] : "";
    $subcategoria = (isset($_POST["subcategoria"]) && $_POST["subcategoria"] != null) ? $_POST["subcategoria"] : "";
    $_SESSION['nome'] = $nome;
    $_SESSION['categoria'] = $categoria;
    $_SESSION['subcategoria'] = $subcategoria;
} else {
    $nome = (isset($_SESSION['nome']) && $_SESSION['nome'] != null) ? $_SESSION['nome'] : "";
    $categoria = (isset($_SESSION['categoria']) && $_SESSION['categoria'] != null) ? $_SESSION['categoria'] : "";
    $subcategoria = (isset($_SESSION['subcategoria']) && $_SESSION['subcategoria'] != null) ? $_SESSION['subcategoria'] : "";
}

// Chama a função da conexão PDO:
require 'conection.php';
// Pega todas as categorias e exibe como opções no form de busca:
try {
    $pdo = db_connect();
    $stmt1 = $pdo->prepare("SELECT categoria_id, categoria_nm FROM tb_categoria");
    $stmt1->execute();
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}

// Pega todas as subcategorias e exibe como opções no form de busca:
try {
    $pdo = db_connect();
    $stmt2 = $pdo->prepare("SELECT subcategoria_id, subcategoria_nm FROM tb_subcategoria");
    $stmt2->execute();
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}


// Listar Produtos:
try {
    $pdo = db_connect();
    // Instrução de consulta para paginação e busca com filtro:
    if(($categoria == '*') && ($subcategoria == '*')):
        $sql = "SELECT a.produto_id, a.produto_nm, a.produto_preco, b.categoria_nm, c.subcategoria_nm FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE '%$nome%' LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
        $stm = $pdo->prepare($sql);   
        $stm->execute();   
        $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
        // Conta quantos registos existem na tabela:  
        $sqlCount = "SELECT COUNT(produto_id) AS total_registros FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.Produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE '%$nome%'";   
        $stmCount = $pdo->prepare($sqlCount);   
        $stmCount->execute();   
        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
    elseif(($categoria != '*') && ($subcategoria == '*')):
        $sql = "SELECT a.produto_id, a.produto_nm, a.produto_preco, b.categoria_nm, c.subcategoria_nm FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE '%$nome%' AND a.produto_categoria_fk = $categoria LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
        $stm = $pdo->prepare($sql);   
        $stm->execute();   
        $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
        // Conta quantos registos existem na tabela:  
        $sqlCount = "SELECT COUNT(produto_id) AS total_registros FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.Produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE  '%$nome%' AND a.produto_categoria_fk = $categoria";   
        $stmCount = $pdo->prepare($sqlCount);   
        $stmCount->execute();   
        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
    elseif(($categoria == '*') && ($subcategoria != '*')):
        $sql = "SELECT a.produto_id, a.produto_nm, a.produto_preco, b.categoria_nm, c.subcategoria_nm FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE '%$nome%' AND a.produto_subcategoria_fk = $subcategoria LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
        $stm = $pdo->prepare($sql);   
        $stm->execute();   
        $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
        // Conta quantos registos existem na tabela:  
        $sqlCount = "SELECT COUNT(produto_id) AS total_registros FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.Produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE  '%$nome%' AND a.produto_subcategoria_fk = $subcategoria";   
        $stmCount = $pdo->prepare($sqlCount);   
        $stmCount->execute();   
        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
    else:
        $sql = "SELECT a.produto_id, a.produto_nm, a.produto_preco, b.categoria_nm, c.subcategoria_nm FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE '%$nome%' AND a.produto_categoria_fk = $categoria AND a.produto_subcategoria_fk = $subcategoria LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
        $stm = $pdo->prepare($sql);   
        $stm->execute();   
        $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
        // Conta quantos registos existem na tabela:  
        $sqlCount = "SELECT COUNT(produto_id) AS total_registros FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_status = 'Ativo' AND a.Produto_categoria_fk = b.categoria_id AND a.Produto_subcategoria_fk = c.subcategoria_id AND a.produto_nm LIKE  '%$nome%' AND a.produto_categoria_fk = $categoria AND a.produto_subcategoria_fk = $subcategoria";   
        $stmCount = $pdo->prepare($sqlCount);   
        $stmCount->execute();   
        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
    endif;
                                                 
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
}?>

