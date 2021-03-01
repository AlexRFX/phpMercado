<?php
// Função que conecta com o MySQL usando PDO:
function db_connect(){
    try{
        $pdo=new PDO("mysql:host=localhost;dbname=mercadomp", "root", "");
        //$pdo=new PDO("mysql:host=localhost;dbname=id16272751_mercadomp", "id16272751_alexrfx", "oZgdV58REMNzH]");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch(PDOException $e){
        echo "Connection error:". $e->getMessage();
    }
}?> 

