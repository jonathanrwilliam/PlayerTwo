<?php
//Verificar se existe seção iniciada
session_start();
if (!isset($_SESSION['uid'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

//Verificar se é admin
function is_admin(){
    if (isset($_SESSION['admin']) && $_SESSION['admin']==true){
        return true;
    }else{
        return false;
    }
}

require_once './config.php';
require_once './core.php';


// Direcionar de acordo com admin
if(is_admin()){
    $module = 'noticiasAdmin';
}else{
    $module = 'home';
}

// Carregar ação
#$action = ...

// Testar se existe ficheiro a carregar. caso contrário carregar HOME
if (file_exists("{$module}.php")){
    require_once "{$module}.php";
}else{
    require_once "home.php";
}

?>