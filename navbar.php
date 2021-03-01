<?php
// inclui o arquivo de inicialização:
require 'init.php';
$pagina
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <?php If($pagina != "Home"):?>
    <a class="navbar-brand" href="index.php">Home</a>
  <?php else: ?>
      <a class="navbar-brand">Home</a>
  <?php endif ?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
         
      <?php // Exibe o nome da Pagina atual se não for a Home:
      If($pagina != "Home"):?>
        <li class="nav-item active">
            <a class="nav-link"><?php echo $pagina ?> <span class="sr-only">(current)</span></a>
        </li>
      <?php endif; 
      // Botão para a pagina: Produtos
      If($pagina != "Produtos"):?>
        <li class="nav-item">
            <a class="nav-link" href="produtos.php">Produtos</a>
        </li>
      <?php endif;
      // Botão para a pagina: Contato
      If($pagina != "Contato"):?>
        <li class="nav-item">
            <a class="nav-link" href="Contato.php">Contato</a>
        </li>
      <?php endif ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php // Verificar se o usuario não está logado:
        if (!loggedin()){ ?>
             Entrar
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="User/login.php">Login</a>
                <a class="dropdown-item" href="User/cadastro.php">Cadastro</a>
            </div>
        <?php // Se o usuario estiver logado:
        } else {
            echo $_SESSION['usuario_nm']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="painel/opcoes.php">Opções</a>
                <a class="dropdown-item" href="user/user-logout.php">Logout</a>
            </div>
        <?php } ?>
      </li>
    </ul>
  </div>
</nav>
