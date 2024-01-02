<?php
require_once './objects/Usuarios.php';
require_once './objects/Orientacao.php';
require_once './objects/Distritos.php';
require_once './objects/Genero.php';
require_once './objects/Jogos.php';

$pdo = connectDB($db);
$user = new Usuarios($pdo);
$user->id = $_SESSION['uid'];
$listaOrientacao = new Orientacao($pdo);
$listaDistritos = new Distritos($pdo);
$listaGenero = new Genero($pdo);
$jogos = new Jogos($pdo);

require_once './config.php';
require_once './core.php';

// Carregar dados do utilizador
$user->readOne();

// Atualizar dados
$update = filter_input(INPUT_POST, 'username');

if ($update) {
    // obter valores do form e colocar no $user
    $user->name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->district = filter_input(INPUT_POST, 'district');
    $user->sexuality = filter_input(INPUT_POST, 'sexuality');
    $user->orientation = filter_input(INPUT_POST, 'orientation');
    $user->discord = filter_input(INPUT_POST, 'discord', FILTER_SANITIZE_URL);
    $user->instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_URL);
    $user->description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $user->update();
}
// Atualizar foto
$updateFoto = filter_input(INPUT_POST, 'updateFoto');
if ($updateFoto) {
    require_once './mod/perfil/updateFoto.php';
    $user->readOne();
}

// Add jogo
$addJogo = filter_input(INPUT_POST, 'addJogo');
if ($addJogo) {
    $jogo = $_POST['jogos'];
    $jogos->addJogo($jogo);
    $user->readOne();
}

// Delete jogo
$deleteJogo = filter_input(INPUT_POST, 'delJogo');
if ($deleteJogo) {
    $jogo = $_POST['jogos'];
    $jogos->delJogo($jogo);
    $user->readOne();
}



?>
<div>
  <?= $html ?>
</div>
<main class="container bg-azul p-3">
    <div class="d-flex conteudo-perfil">
        <?php
        
        if ($user->profilepicture == null) {
            $url = WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';
        } else {
            $url = WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $user->profilepicture;
        }
        ?>
        <!-- Form Update foto de perfil -->
        <div class="col">
            <form method="post" enctype="multipart/form-data" action="?m=perfil&a=verPerfil">
                <div class="mx-auto mb-3 mb-md-0 fotoPerfil col-4 position-relative" style="background-image: url('<?php echo $url; ?>');">
                    <button type="submit" name="updateFoto" class="btn btn-success position-absolute bottom-0 start-50 translate-middle-x mb-2" value="Upload">Alterar foto</button>
                </div>
                <div class="form-group mb-3 mt-3">
                    <input type="file" class="form-control" name="fileToUpload" required>
                </div>
            </form>
        </div>
        <!-- Form Update dados perfil -->
        <div class="col">
            <form method="post">
                <div class="container px-0">
                    <!-- Linha 1: Nome, Distrito -->
                    <div class="row mb-3 mx-3">
                        <div class="col me-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="username" value="<?= $user->name ?>">
                        </div>
                        <div class="col">
                            <label for="distrito" class="form-label">Distrito</label>
                            <select name="district" id="district" class="form-select">
                                <?php $listaDistritos->read($user); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Linha 2: Gênero e Orientação -->
                    <div class="row mb-3 mx-3">
                        <div class="col me-3">
                            <label for="genero" class="form-label">Género</label>
                            <select name="sexuality" id="sexuality" class="form-select">
                                <?php $listaGenero->read($user); ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="orientacao" class="form-label">Orientação</label>
                            <select name="orientation" id="orientation" class="form-select">
                                <?php $listaOrientacao->read($user); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Linha 3: Links -->
                    <div class="row mb-3 mx-3">
                        <div class="col me-3">
                            <label for="genero" class="form-label">Discord</label>
                            <input type="text" class="form-control" name="discord" value="<?= $user->discord ?>">
                        </div>
                        <div class="col">
                            <label for="orientacao" class="form-label">Intagram</label>
                            <input type="text" class="form-control" name="instagram" value="<?= $user->instagram ?>">
                        </div>
                    </div>

                    <!-- Linha 4: Descrição -->
                    <div class="row mb-3 mx-3">
                        <div class="col">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="description" rows="4"><?= $user->description ?></textarea>
                        </div>
                    </div>

                    <!-- Linha 5: Jogos -->
                    <div class="row mb-5 mx-3">
                        <div class="col">
                            <label for="jogos" class="form-label">Jogos</label>
                            <div class="d-flex">

                                <select name="jogos" id="jogo" class="form-select">
                                    <?php $jogos->list(); ?>
                                </select>

                                <button type="submit" class="btn btn-success mx-2 btn-sm" name="addJogo" value="addJogo">Adicionar</button>
                                <button type="submit" class="btn btn-danger btn-sm" name="delJogo" value="delJogo">Remover</button>

                                <br>
                            </div>
                            <?php echo $jogos->read($user); ?>
                        </div>
                    </div>

                    <!-- Linha 6: Botões -->
                    <div class="row mx-3">
                        <div class="col text-end">
                            <!-- Update dados perfil -->
                            <button type="submit" class="btn btn-success me-2" name="updatePerfil">Salvar perfil</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</main>