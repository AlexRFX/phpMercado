<?php // Verifica se algum dado foi envia através do metodo POST:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
} else if (!isset($id)) {
    // Se não, se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
 }

// Ação do administrador: Cadastrar/Alterar Categoria: 
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "cadastrar"){
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    Try {
        // Se tiver ID: Atualizar os dados da Categoria cadastrada:
        if($id != ""){
            $stmt = $pdo->prepare("UPDATE tb_categoria SET categoria_nm = ? WHERE categoria_id = ?");
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $id);
        // Se não tiver ID: Verifica se a categoria já está cadastrado:  
        } else {
            $stmtv = $pdo->prepare("SELECT categoria_nm FROM tb_categoria WHERE categoria_nm = :nome");
            $stmtv->bindParam(':nome', $nome); $stmtv->execute();
            if ($stmtv->rowCount() > 0) { 
                $validated = "false"?>
                <h4 class="bg-warning">Essa Categoria já estava cadastrada!</h4>
            <?php 
            // Se não tiver ID: Cadastro da Categoria:
            } else {
                $validated = "true";
                $stmt = $pdo->prepare("INSERT INTO tb_categoria (`categoria_nm`) VALUES (?)");
                $stmt->bindParam(1, $nome);
            }
        } 
        if ($validated == "true") {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {?>
                <h4 class="bg-success">Dados cadastrado com sucesso!</h4>
                <?php // Limpa as variaveis:
                $id = null;
                $nome = null;
            } else {?>
                <h4 class="bg-danger">Cadastro Inválido!</h4>
            <?php }
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
// Ação do administrador: Pegar dados da Categoria:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "alterar" && $id != "") {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    try {
        $stmt = $pdo->prepare("SELECT * FROM tb_categoria WHERE categoria_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $res->categoria_id;
            $nome = $res->categoria_nm;
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do administrador: Deletar Categoria:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "excluir" && $id != "") {
   // Chama a função da conexão PDO:
   require_once '../conection.php';
   $pdo = db_connect();
    try {
        $stmt0 = $pdo->prepare("DELETE FROM tb_subcategoria WHERE subcategoria_categoria_fk = ?");
        $stmt0->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt0->execute()) {
            $stmt = $pdo->prepare("DELETE FROM tb_categoria WHERE categoria_id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmt->execute()) {?>
                <h4 class="bg-success"><b>Categoria deletada com sucesso!</b></h4>
                <?php $id = null;
            } else {
                throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
            }
        }
        throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do Administrador: Ver lista de Categoria
try {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    // Instrução de consulta para paginação: 
    $sql = "SELECT * FROM tb_categoria LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
    $stm3 = $pdo->prepare($sql);   
    $stm3->execute();   
    $dados = $stm3->fetchAll(PDO::FETCH_OBJ);   
   
    // Conta quantos registos existem na tabela:  
    $sqlCount = "SELECT COUNT(categoria_id) AS total_registros FROM tb_categoria";   
    $stmCount = $pdo->prepare($sqlCount);   
    $stmCount->execute();   
    $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                                                 
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
}?>