<?php
session_start();
$html = '';

require_once './config.php';
require_once './core.php';

// Ligação à base de dados
$pdo = connectDB($db);

debug('POST: ' . print_r($_POST, true) . '<br>');
debug('Utilizador: ' . $db['username'] . ' Base de Dados: ' . $db['dbname'] . '<br>');

// Registo de novo usuário
$register = filter_input(INPUT_POST, 'username');

if ($register) {
  require_once './objects/Usuarios.php';

  $usuario = new Usuarios($pdo);

  $html = $usuario->create();
}

// Login
$login = filter_input(INPUT_POST, 'loginEmail');

if ($login) {
  require_once './objects/Usuarios.php';

  $usuario = new Usuarios($pdo);

  $html = $usuario->login();

  debug('SESSION: '.print_r($_SESSION,true).'<br>');

}


?>

<!doctype html>
<html lang="pt" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="static/css/style_login.css">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary-subtle">
  <!-- Login -->
  <main class="w-100 m-auto form-container bg-custom">
    <form class="border p-4 border-light-subtle rounded border-3" method="post">
      <div class="d-flex justify-content-center">
        <img src="static/images/logo_light.png" class="mb-4" height="100" width="100">
      </div>
      <h1 class="h3 mb-3 fw-normal text-center">Iniciar sessão</h1>
      <div class="form-floating">
        <input type="email" name="loginEmail" class="form-control" placeholder="E-mail">
        <label for="floatingInput">E-mail</label>
      </div>
      <div class="form-floating">
        <input type="password" name="loginPassword"class="form-control" placeholder="senha">
        <label class="floatingInput">Senha</label>
      </div>
      <div class="d-flex justify-content-center my-3">
        <a class="link-underline-dark" data-bs-toggle="modal" data-bs-target="#modalCriarConta">Criar nova
          conta</a>
      </div>
      <button class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
    </form>

    <!-- Modal cadastro de novo usuário -->
    <div class="modal fade" id="modalCriarConta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="post">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastro de novo usuário</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="form-floating my-3">
                <input type="text" name="username" class="form-control" placeholder="Nome">
                <label for="floatingInput">Nome</label>
              </div>
              <div class="form-floating my-3">
                <input type="date" name="dateofbirth" class="form-control" placeholder="Data de nascimento">
                <label for="floatingInput">Data de nascimento</label>
              </div>
              <div class="form-floating my-3">
                <input type="text" name="discord" class="form-control" placeholder="Discord">
                <label for="floatingInput">Discord</label>
              </div>
              <div class="form-floating my-3">
                <input type="email" name="email" class="form-control" placeholder="senha">
                <label class="floatingInput">E-mail</label>
              </div>
              <div class="form-floating my-3">
                <input type="password" name="password" class="form-control" placeholder="senha">
                <label class="floatingInput">Senha</label>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div>
      <?= $html ?>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>