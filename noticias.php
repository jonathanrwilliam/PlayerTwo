<!doctype html>
<html lang="pt" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="static/css/style_noticias.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <?php  require_once 'index.php'; ?>

</head>

<body>

  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <main class=" container col-12 col-md-8 bg-azul border-start border-end">
    <div class="p-3">
      <img class="img-fluid" src="https://www.centralcomics.com/wp-content/uploads/2022/07/lgw-2022.png">
    </div>
    <div class="p-3">
      <img class="img-fluid w-100" src="https://forum.pt/images/novo_site/comic_con.jpg">
    </div>

  </main>


  <script src="static/js/noticias.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>