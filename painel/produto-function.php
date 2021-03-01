<?php 
// Verifica se algum dado foi envia através do metodo POST:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $categoria = (isset($_POST["categoria"]) && $_POST["categoria"] != null) ? $_POST["categoria"] : "";
    $subcategoria = (isset($_POST["subcategoria"]) && $_POST["subcategoria"] != null) ? $_POST["subcategoria"] : "";
    $descricao = (isset($_POST["descricao"]) && $_POST["descricao"] != null) ? $_POST["descricao"] : "";
    $preco = (isset($_POST["preco"]) && $_POST["preco"] != null) ? $_POST["preco"] : "";
    $status = (isset($_POST["status"]) && $_POST["status"] != null) ? $_POST["status"] : "";
} else if (!isset($id)) {
    // Se não, se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $categoria = "0";
    $subcategoria = "0";
    $descricao = NULL;
    $preco = NULL;
    $status = NULL;
 }

// Ação do administrador: Cadastrar/Alterar produto: 
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "cadastrar"){
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    Try {
        // Se tiver ID: Atualizar os dados da Sub-Categoria cadastrada:
        if($id != ""){
            $stmt = $pdo->prepare("UPDATE tb_produto SET produto_nm = ?, produto_categoria_fk = ?, produto_subcategoria_fk = ?, produto_ds = ?, produto_preco = ?, produto_status = ? WHERE produto_id = ?");
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $categoria);
            $stmt->bindParam(3, $subcategoria);
            $stmt->bindParam(4, $descricao);
            $stmt->bindParam(5, $preco);
            $stmt->bindParam(6, $status);
            $stmt->bindParam(7, $id);
        // Se não tiver ID: Verifica se o produto já está cadastrado:  
        } else {
            $stmtv = $pdo->prepare("SELECT produto_nm FROM tb_produto WHERE produto_nm = :nome");
            $stmtv->bindParam(':nome', $nome); $stmtv->execute();
            if ($stmtv->rowCount() > 0) { 
                $validated = "false"?>
                <h4 class="bg-warning">Esse Produto já estava cadastrado!</h4>
            <?php 
            // Se não tiver ID: Cadastra o Produto:
            } else {
                $validated = "true";
                $stmt = $pdo->prepare("INSERT INTO tb_produto (`produto_nm`, `produto_categoria_fk`, `produto_subcategoria_fk`, `produto_ds`, `produto_preco`, `produto_status`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $categoria);
                $stmt->bindParam(3, $subcategoria);
                $stmt->bindParam(4, $descricao);
                $stmt->bindParam(5, $preco);
                $stmt->bindParam(6, $status);
            }
        }
        if ($validated == "true") {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {?>
                <h4 class="bg-success">Dados cadastrado com sucesso!</h4>
                <?php // Limpa as variaveis:
                $id = null;
                $nome = null;
                $categoria = "0";
                $subcategoria = "0";
                $descricao = NULL;
                $preco = NULL;
                $status = NULL;
            } else {?>
                <h4 class="bg-danger">Cadastro Inválido!</h4>
            <?php }
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
// Ação do administrador: Pegar dados do Produto:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "alterar" && $id != "") {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    try {
        $stmt = $pdo->prepare("SELECT * FROM tb_produto WHERE produto_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $res->produto_id;
            $nome = $res->produto_nm;
            $categoria = $res->produto_categoria_fk;
            $subcategoria = $res->produto_subcategoria_fk;
            $descricao = $res->produto_ds;
            $preco = $res->produto_preco;
            $status = $res->produto_status;
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do administrador: Deletar Produto:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "excluir" && $id != "") {
   // Chama a função da conexão PDO:
   require_once '../conection.php';
   $pdo = db_connect();
    try {
        $stmt = $pdo->prepare("DELETE FROM tb_produto WHERE produto_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {?>
            <h4 class="bg-success"><b>Produto deletado com sucesso!</b></h4>
            <?php $id = null;
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do Administrador: Ver lista de Produto
try {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    // Instrução de consulta para paginação: 
    $sql = "SELECT a.produto_id, a.produto_nm, a.produto_status, b.categoria_nm, c.subcategoria_nm FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_categoria_fk = b.categoria_id AND a.Produto_subcategoria_fk = c.subcategoria_id LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
    $stm3 = $pdo->prepare($sql);   
    $stm3->execute();   
    $dados = $stm3->fetchAll(PDO::FETCH_OBJ);   
   
    // Conta quantos registos existem na tabela:  
    $sqlCount = "SELECT COUNT(produto_id) AS total_registros FROM tb_produto a, tb_categoria b, tb_subcategoria c WHERE a.Produto_categoria_fk = b.categoria_id AND a.Produto_subcategoria_fk = c.subcategoria_id";   
    $stmCount = $pdo->prepare($sqlCount);   
    $stmCount->execute();   
    $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                                                 
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
}

// Pega todas as categorias e exibe como opções no form:
try {
    $pdo = db_connect();
    $stmt3 = $pdo->prepare("SELECT categoria_id, categoria_nm FROM tb_categoria");
    $stmt3->execute();
} catch (PDOException $erro) {
    echo "Erro: ".$erro->getMessage();
}

// Pega todas as subcategorias e exibe como opções no form:
if($categoria == '0'){
    try {
        $pdo = db_connect();
        $stmt4 = $pdo->prepare("SELECT subcategoria_id, subcategoria_nm FROM tb_subcategoria WHERE subcategoria_categoria_fk = $categoria");
        $stmt4->execute();
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
} else{
    try {
        $pdo = db_connect();
        $stmt4 = $pdo->prepare("SELECT subcategoria_id, subcategoria_nm FROM tb_subcategoria");
        $stmt4->execute();
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
};?>