<?php
// Cria um hash simples da senha, usando MD5:
function make_hash($str){
    return md5($str);
}

// Verifica se o usuario está, logado:
function loggedin(){
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
        return false;
    }
    return true;
}

// Função que retorna o nome da opção:
function optionname($optiontype, $optionname){
        $pdo = db_connect();
        if($optiontype == 'categoria'):
            $stmt = $pdo->prepare("SELECT categoria_nm AS value FROM tb_categoria WHERE categoria_id = $optionname LIMIT 1");
        else:
            $stmt = $pdo->prepare("SELECT subcategoria_nm AS value FROM tb_subcategoria WHERE subcategoria_id = $optionname LIMIT 1");
        endif;
        
        $stmt->execute();
        $data = $stmt->fetch();
        $result = $data['value'];

        return $result;
}?>
