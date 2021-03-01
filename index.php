<?php
session_start();
$pagina = "Home";
// inclui o arquivo de inicializão:
require 'init.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
        <?php
        // Include da NavBar
        include 'navbar.php';
        ?>
    </body>
</html>
