<?php

require_once './config.php';
require_once './core.php';
require_once './objects/Usuarios.php';

$pdo = connectDB($db);

if (isset($_GET['id'])) {
    $idTerceiro = $_GET['id'];
}

$user = new Usuarios($pdo);
$user->id = $idTerceiro;


$user->readOne();


?>

<main class="container bg-azul p-3">
    <div class="d-flex conteudo-perfil">
        <!--<div class="mx-auto mb-3 mb-md-0 fotoPerfil col-4"></div>-->
        <?php
        if ($user->profilepicture == null) {
            $url = WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';
        } else {
            $url = WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $user->profilepicture;
        }
        ?>
        <div class="mx-auto mb-3 mb-md-0 fotoPerfil col-4 position-relative" style="background-image: url('<?php echo $url; ?>');"></div>
        <div class="container px-0">
            <!-- Linha 1: Nome, Idade, Distrito -->
            <div class="row mb-3 mx-3">
                <div class="col me-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" value="<?php echo $user->name ?>" readonly>
                </div>
                <div class="col">
                    <label for="distrito" class="form-label">Distrito</label>
                    <input type="text" class="form-control" id="distrito" value="<?php echo $user->district ?>" readonly>
                </div>
            </div>

            <!-- Linha 2: Gênero e Orientação -->
            <div class="row mb-3 mx-3">
                <div class="col me-3">
                    <label for="genero" class="form-label">Género</label>
                    <input type="text" class="form-control" id="genero" value="<?php echo $user->sexuality ?>" readonly>
                </div>
                <div class="col">
                    <label for="orientacao" class="form-label">Orientação</label>
                    <input type="text" class="form-control" id="orientacao" value="<?php echo $user->orientation ?>" readonly>
                </div>
            </div>

            <!-- Linha 3: Links -->
            <div class="row mb-3 mx-3">
                <div class="col me-3">
                    <label for="genero" class="form-label">Discord</label>
                    <input type="text" class="form-control" id="discord" value="<?php echo $user->discord ?>" readonly>
                </div>
                <div class="col">
                    <label for="orientacao" class="form-label">Intagram</label>
                    <input type="text" class="form-control" id="instagram" value="<?php echo $user->instagram ?>" readonly>
                </div>
            </div>

            <!-- Linha 4: Descrição -->
            <div class="row mb-3 mx-3">
                <div class="col">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="4" readonly><?php echo $user->description ?></textarea>
                </div>
            </div>

            <!-- Linha 5: Jogos -->
            <div class="row mb-5 mx-3">
                <div class="col">
                    <label for="jogos" class="form-label">Jogos</label>
                    <br>
                    <span class="badge bg-dark">Smite</span>
                    <span class="badge bg-dark">League of Legends</span>
                    <span class="badge bg-dark">Minecraft</span>
                </div>
            </div>

            <!-- Linha 6: Botões -->
            <div class="row mx-3">
                <div class="col text-end">
                    <button type="button" class="btn btn-success me-2">Convidar para jogar</button>
                </div>
            </div>
        </div>



</main>