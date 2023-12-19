<?php

require_once 'core.php';
require_once './objects/Usuarios.php';
require_once './objects/Posts.php';

$pdo = connectDB($db);
$user = new Usuarios($pdo);
$user->id = $_SESSION['uid'];
$listarPosts = new Posts($pdo);

if (!is_admin()) {
  header("Location: index.php?module=home&action=home");
  exit();
}

// Inserir post
$new = filter_input(INPUT_POST, 'newPost');
if ($new) {
  require_once './mod/noticias/addPost.php';
}

//Verificar qual post está sendo chamado
print_r($_POST);

//Deletar post
$delete = filter_input(INPUT_POST, 'deletePost');
if ($delete) {
  require_once './mod/noticias/deletePost.php';
}

?>
<div>
  <?= $html ?>
</div>
<main class=" container col-12 col-md-8 bg-azul border-start border-end">
  <form method="post" enctype="multipart/form-data" action="?m=noticias&a=addPost">
    <div class="input-group p-3">
      <label class="input-group-text" for="inputGroupFile01">Adicionar</label>
      <input type="file" class="form-control" name="fileToUpload" required>
      <button type="submit" name="newPost" class="btn btn-success" value="Upload">Salvar</button>
    </div>
  </form>
  <?php $listarPosts->readAll(); ?>
</main>