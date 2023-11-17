<?php
session_start();
if (!isset($_SESSION['uid'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

define('DESC', 'Aplicação Web');
$html = '';
$debug = '';

require_once './config.php';
require_once './core.php';

// Carregar módulo ativo
#$module = ...

// Carregar ação
#$action = ...

// Testar se existe ficheiro a carregar. caso contrário carregar HOME
#if (...){
#    $module = 'home';
#}else{
#    // Ligar à base de dados
#    $pdo = ...
#}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= DESC ?>">
        <meta name="author" content="<?= AUTHOR ?>">
        <title>Aplicação Web</title>

        <!-- Favicons -->
        <link rel="icon" href="media/favicon.ico" sizes="any">
        <link rel="icon" href="media/logo.svg" sizes="any" type="image/svg+xml">
        <link rel="icon" href="media/logo_128x128.png" sizes="128x128" type="image/png">
        <link rel="icon" href="media/logo_32x32.png" sizes="32x32" type="image/png">
        <meta name="theme-color" content="#712cf9">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    </head>
    <body>
        <div class="container container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Produtos</a>
                        </li>
                        <?= is_admin() ? '
                        <li class="nav-item">
                            <a class="nav-link" href="#">Utilizadores</a>
                        </li>' : ''
                        ?>
                        <li class="nav-item dropdown ml-md-auto">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                                <img src="" width="30" alt="avatar">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="?m=user&a=profile">Dados Pessoais</a>
                                <a class="dropdown-item" href="?m=user&a=preferences">Preferências</a>
                                <?= is_admin() ? '<a class="dropdown-item" href="?m=config">Configurações</a>' : '' ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Terminar Sessão</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <header><h2>-=[ <?= DESC ?> ]=-</h2></header>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    // Requerer módulo e ação
                    #if(...){
                    #    ...
                    #}else{
                    #    echo 'Seja bem-vindo! Deve utilizar uma das opções do menu da aplicação.';
                    #}
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= debug() ? '<hr><code><b>DEBUG:</b><br>'.$debug.'<br>POST: ' . print_r($_POST, true) . '<br>GET: ' . print_r($_GET, true) . '<br>SESSION: ' . print_r($_SESSION, true) . '<br>is_admin(): ' . is_admin() . '</code>' : '' ?>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>