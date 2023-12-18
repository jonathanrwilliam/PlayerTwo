<?php
require_once './objects/Usuarios.php';
$user = new Usuarios(connectDB($db));
$user->id = $_SESSION['uid'];

$user->readOne();

?>

<header>
  <nav class="navbar navbar-expand py-1 bg-dark border-bottom">
    <div class="container-fluid">
      <a class="navbar-brand" href="?m=home&a=home">
        <img src="static/images/logo_light.png" alt="logo" width="40" height="40" class="d-inline-block align-text-top">
      </a>
    </div>
    <ul class="navbar-nav d-flex flex-row d-flex align-items-center">
      <!--ícone dinâmico convites-->
      <li class="nav-item me-3 me-lg-0">
        <a href="#" class="nav-link text-white d-lg-none" id="showConvites"><i class="bi bi-person-fill-add fs-3 mx-1"></i></a>
      </li>
      <!--Ícone dinâmico conversas-->
      <li class="nav-item me-3 me-lg-0">
        <a href="#" class="nav-link text-white d-lg-none" id="showConversas"><i class="bi bi-envelope-fill fs-3 mx-1"></i></a>
      </li>
      <!--Demais ícones-->
      <li class="nav-item me-3 me-lg-0">
        <a class="nav-link text-white" href="?m=noticias&a=noticias"><i class="bi bi-calendar-event-fill fs-4 mx-1"></i></a>
      </li>
      <li class="nav-item me-3 me-lg-0">
        <a class="nav-link text-white" href="#"><i class="bi bi-bell-fill fs-4 mx-1"></i></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php
          if ($user->profilepicture == null) {
            $url = 'https://esan-tesp-ds-paw.web.ua.pt/tesp-ds-g8/Projeto/static/images/profile_avatar.jpg';
          } else {
            $url = WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $user->profilepicture;
          }
          ?>
          <img src="<?php echo $url; ?>" alt="profile" width="40" height="40" style="border-radius: 50%; object-fit:cover">
          <?= $_SESSION['username'] ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="?m=perfil&a=verPerfil">Meu perfil</a></li>
          <li class="dropdown-divider"></li>
          <li><a id="logout" class="dropdown-item" href="logout.php">Sair</a></li>
        </ul>
      </li>
    </ul>
    </div>
  </nav>
</header>