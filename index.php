<?php
//Verificar se existe seção iniciada
session_start();
if (!isset($_SESSION['uid'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

require_once 'config.php';
require_once 'core.php';

$module = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Carregar ação
$action = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



// Direcionar de acordo com admin
if (is_admin()) {
    $module = 'noticias';
    $action = 'noticiasAdmin';
} else {

    
    // Testar se existe ficheiro a carregar. caso contrário carregar HOME
    if (!file_exists("mod/$module/$action.php")) {
        $module = 'home';
        $action = 'home';
    }
}

?>

<!DOCTYPE html>
<html lang="pt" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $module ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="static/css/style_<?= $module ?>.css">
</head>

<body>
    <?php
    include_once 'mod/navbar.php';


    require_once "mod/$module/$action.php";


    ?>

    <div>
        <?= debug() ? $_DEBUG : '' ?>
    </div>
    <script src="static/js/<?= $module ?>.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>