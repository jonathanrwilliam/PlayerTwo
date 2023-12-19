<?php
require_once './objects/Usuarios.php';
require_once './objects/Posts.php';

$pdo = connectDB($db);

$user->id = $_SESSION['uid'];

$listarPosts = new Posts($pdo);

require_once './config.php';
require_once './core.php';


?>

<main class=" container col-12 col-md-8 bg-azul border-start border-end">
  <?php $listarPosts->readAllUser(); ?>
  <!--
  <div class="p-3">
    <img class="img-fluid" src="https://www.centralcomics.com/wp-content/uploads/2022/07/lgw-2022.png">
  </div>-->
</main>