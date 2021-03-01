<?php // Verifica se algum dado foi envia através do metodo POST:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $categoria = (isset($_POST["categoria"]) && $_POST["categoria"] != null) ? $_POST["categoria"] : "";
} else if (!isset($id)) {
    // Se não, se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $categoria = "0";
 }

// Ação do administrador: Cadastrar/Alterar Sub-Categoria: 
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "cadastrar"){
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    Try {
        // Se tiver ID: Atualizar os dados da Sub-Categoria cadastrada:
        if($id != ""){
            $stmt = $pdo->prepare("UPDATE tb_subcategoria SET subcategoria_nm = ?, subcategoria_categoria_fk = ? WHERE subcategoria_id = ?");
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $categoria);
            $stmt->bindParam(3, $id);
        // Se não tiver ID: Verifica se a sub-categoria já está cadastrado:  
        } else {
            $stmtv = $pdo->prepare("SELECT subcategoria_nm FROM tb_subcategoria WHERE subcategoria_nm = :nome");
            $stmtv->bindParam(':nome', $nome); $stmtv->execute();
            if ($stmtv->rowCount() > 0) { 
                $validated = "false"?>
                <h4 class="bg-warning">Essa Sub-Categoria já estava cadastrada!</h4>
            <?php 
            // Se não tiver ID: Cadastro da Sub-Categoria:
            } else {
                $validated = "true";
                $stmt = $pdo->prepare("INSERT INTO tb_subcategoria (`subcategoria_nm`, `subcategoria_categoria_fk`) VALUES (?, ?)");
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $categoria);
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
            } else {?>
                <h4 class="bg-danger">Cadastro Inválido!</h4>
            <?php }
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
// Ação do administrador: Pegar dados da Sub-Categoria:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "alterar" && $id != "") {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    try {
        $stmt = $pdo->prepare("SELECT * FROM tb_subcategoria WHERE subcategoria_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $res->subcategoria_id;
            $nome = $res->subcategoria_nm;
            $categoria = $res->subcategoria_categoria_fk;
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do administrador: Deletar Sub-Categoria:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "excluir" && $id != "") {
   // Chama a função da conexão PDO:
   require_once '../conection.php';
   $pdo = db_connect();
    try {
        $stmt = $pdo->prepare("DELETE FROM tb_subcategoria WHERE subcategoria_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {?>
            <h4 class="bg-success"><b>Categoria deletada com sucesso!</b></h4>
            <?php $id = null;
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do Administrador: Ver lista de Sub-Categoria
try {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    // Instrução de consulta para paginação: 
    $sql = "SELECT a.subcategoria_id, a.subcategoria_nm, b.categoria_nm FROM tb_subcategoria a, tb_categoria b WHERE a.subcategoria_categoria_fk = b.categoria_id LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
    $stm3 = $pdo->prepare($sql);   
    $stm3->execute();   
    $dados = $stm3->fetchAll(PDO::FETCH_OBJ);   
   
    // Conta quantos registos existem na tabela:  
    $sqlCount = "SELECT COUNT(subcategoria_id) AS total_registros FROM tb_subcategoria a, tb_categoria b WHERE a.subcategoria_categoria_fk = b.categoria_id";   
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
};?>