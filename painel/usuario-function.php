<?php // Verifica se algum dado foi envia através do metodo POST:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : NULL;
    $senha = make_hash($senha);
} else if (!isset($id)) {
    // Se não, se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $email = NULL;
    $senha = NULL;
 }

// Ação do administrador: Cadastrar/Alterar Usuario: 
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "cadastrar"){
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    Try {
        // Se tiver ID: Atualizar os dados do Usuario cadastrado:
        if($id != ""){
            $stmt = $pdo->prepare("UPDATE tb_usuario SET usuario_nm = ?, usuario_email = ?, usuario_senha = ? WHERE usuario_id = ?");
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $senha);
            $stmt->bindParam(4, $id);
        // Se não tiver ID: Verifica se o e-mail já está cadastrado:  
        } else {
            $stmtv = $pdo->prepare("SELECT usuario_email FROM tb_usuario WHERE usuario_email = :email");
            $stmtv->bindParam(':email', $email); $stmtv->execute();
            if ($stmtv->rowCount() > 0) { ?>
                <h4 class="bg-warning">Esse E-mail já foi cadastrado!</h4>
            <?php 
            // Se não tiver ID: Cadastrar no Usuario:
            } else {
                $stmt = $pdo->prepare("INSERT INTO tb_usuario (`usuario_nm`, `usuario_email`, `usuario_senha`, `usuario_adm`) VALUES (?, ?, ?, 0)");
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $senha); 
            }
        }
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {?>
                <h4 class="bg-success">Dados cadastrado com sucesso!</h4>
                <?php // Limpa as variaveis:
                $id = null;
                $nome = null;
                $email = null;
                $senha = null;
            } else {?>
                <h4 class="bg-danger">Cadastro Inválido!</h4>
            <?php }
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
// Ação do administrador: Pegar dados do usuario:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "alterar" && $id != "") {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    try {
        $stmt = $pdo->prepare("SELECT * FROM tb_usuario WHERE usuario_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $res->usuario_id;
            $nome = $res->usuario_nm;
            $email = $res->usuario_email;
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do administrador: Deletar Usuario:
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "excluir" && $id != "") {
   // Chama a função da conexão PDO:
   require_once '../conection.php';
   $pdo = db_connect();
    try {
        $stmt = $pdo->prepare("DELETE FROM tb_usuario WHERE usuario_id  = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {?>
            <h4 class="bg-success"><b>Usuario deletado com sucesso!</b></h4>
            <?php $id = null;
        } else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Ação do Administrador: Ver lista de usuarios
try {
    // Chama a função da conexão PDO:
    require_once '../conection.php';
    $pdo = db_connect();
    // Instrução de consulta para paginação: 
    $sql = "SELECT usuario_id, usuario_nm, usuario_email FROM tb_usuario WHERE usuario_adm = 0 LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
    $stm3 = $pdo->prepare($sql);   
    $stm3->execute();   
    $dados = $stm3->fetchAll(PDO::FETCH_OBJ);   
   
    // Conta quantos registos existem na tabela:  
    $sqlCount = "SELECT COUNT(usuario_id) AS total_registros FROM tb_usuario WHERE usuario_adm = 0";   
    $stmCount = $pdo->prepare($sqlCount);   
    $stmCount->execute();   
    $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                                                 
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
}?>