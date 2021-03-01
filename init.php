<?php 
 /*=============================
   Configurações do PHP
   =============================*/
 // Define valores padrão para diretivas do php.ini
ini_set( 'error_reporting', -1 );
ini_set( 'display_errors', 0 ); // deve ser definida para zero (0) em ambiente de produção
 
// Timezone:
date_default_timezone_set( 'America/Sao_Paulo' ); 
 
// Tempo máximo de execução de um script:
set_time_limit( 60 );

/*======================================
   Cria constantes usadas na aplicação
  ======================================*/
// conexão com base de dados:
define( 'BD_SERVIDOR', 'localhost' );
define( 'BD_USUARIO', 'root' );
define( 'BD_SENHA', '' );
define( 'BD_NOME', 'mercadomp' );

/* Constantes de configuração */  
define('QTDE_REGISTROS', 5);   
define('RANGE_PAGINAS', 10);

// habilita todas as exibições de erros:
ini_set('display_errors', true);
error_reporting(E_ALL);

// inclui o arquivo de funções:
require_once 'functions.php';