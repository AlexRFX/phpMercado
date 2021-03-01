<?php
if (!loggedin()){
    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "login"){
        // Resgata variáveis do formulário do login.php:
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
        // Caso falte algum parametro:
        if (empty($email) || empty($senha)){?>
            <h4 class="bg-warning fonte2">Informe email e/ou senha</h4> 
        <?php
        }else{
            // Cria o hash da senha:
            $senha = make_hash($senha);
        
            // Chama a função da conexão PDO:
            require_once '../conection.php';
            $pdo = db_connect();

            $sql = "SELECT usuario_id, usuario_nm, usuario_adm FROM tb_usuario WHERE usuario_email = :email AND usuario_senha = :senha";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);

            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Messagem de erro:
            if (count($users) <= 0){?>
                <h4 class="bg-danger fonte2">Login e/ou senha incorretos</h4>
            <?php }else{
                // Pega o usuário atual
                $user = $users[0];
                $_SESSION['logged_in'] = true;
                $_SESSION['usuario_id'] = $user['usuario_id'];
                $_SESSION['usuario_nm'] = $user['usuario_nm'];
                $_SESSION['usuario_adm'] = $user['usuario_adm'];
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    }
}?>

