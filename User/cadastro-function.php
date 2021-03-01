<?php
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "cadastrar"){
    // Resgata variáveis do formulário do cadastro.php:
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Caso falte algum parametro:
    if (empty($nome) || empty($email) || empty($senha)){?>
        <h4 class="bg-warning">Informe nome, email e senha!</h4>
    <?php } else {
        // Chama a função da conexão PDO:
        require_once '../conection.php';
        $pdo = db_connect();

        // Verifica se o e-mail já foi cadastrado no Banco de Dados:
        $stmt = $pdo->prepare("SELECT usuario_email FROM tb_usuario WHERE usuario_email = :email");
        $stmt->bindParam(':email', $email); $stmt->execute();
        if ($stmt->rowCount() > 0) { ?>
            <h4 class="bg-warning">Esse E-mail já foi cadastrado!</h4>
        
        <?php } else {
            // Cria o hash da senha:
            $senha = make_hash($senha);

            // Insere os dados no Banco de Dados:
            $stmt2 = $pdo->prepare("INSERT INTO tb_usuario (`usuario_nm`, `usuario_email`, `usuario_senha`, `usuario_adm`) VALUES (?, ?, ?, 0)");
            $stmt2->bindParam(1, $nome);
            $stmt2->bindParam(2, $email);
            $stmt2->bindParam(3, $senha);
            if ($stmt2->execute()) {
                if ($stmt2->rowCount() > 0) {?>
                    <h4 class="bg-success">Cadastro efetuado com sucesso!</h4>
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
        }
    }
}?>