<!DOCTYPE html>
<html lang="pt" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    
</head>

<body>
    <header>
        <nav class="navbar navbar-expand py-1 bg-dark border-bottom">
          <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
              <img src="static/images/logo_light.png" alt="logo" width="40" height="40" class="d-inline-block align-text-top">
            </a>
          </div>
          <ul class="navbar-nav d-flex flex-row d-flex align-items-center">
            <!--ícone dinâmico convites-->
            <li class="nav-item me-3 me-lg-0">
              <a href="#" class="nav-link text-white d-lg-none" id="showConvites"><i
                  class="bi bi-person-fill-add fs-3 mx-1"></i></a>
            </li>
            <!--Ícone dinâmico conversas-->
            <li class="nav-item me-3 me-lg-0">
              <a href="#" class="nav-link text-white d-lg-none" id="showConversas"><i
                  class="bi bi-envelope-fill fs-3 mx-1"></i></a>
            </li>
            <!--Demais ícones-->
            <li class="nav-item me-3 me-lg-0">
              <a class="nav-link text-white" href="noticias.php"><i class="bi bi-calendar-event-fill fs-4 mx-1"></i></a>
            </li>
            <li class="nav-item me-3 me-lg-0">
              <a class="nav-link text-white" href="#"><i class="bi bi-bell-fill fs-4 mx-1"></i></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="static/images/profile_avatar.png" alt="profile" width="40" height="40">
                <?= $_SESSION['username'] ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="perfil.php">Meu perfil</a></li>
                <li class="dropdown-divider"></li>
                <li><a id="logout" class="dropdown-item" href="logout.php">Sair</a></li>
              </ul>
            </li>
          </ul>
          </div>
        </nav>
      </header>

</body>

</html>