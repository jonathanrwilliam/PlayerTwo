<?php
require_once './objects/Usuarios.php';
require_once './objects/Orientacao.php';
$user = new Usuarios(connectDB($db));
$user->id = $_SESSION['uid'];
$lista = new Orientacao(connectDB($db));

require_once './config.php';
require_once './core.php';

$html = '';

// Carregar dados do utilizador
$user->readOne();

// Atualizar dados
$update = filter_input(INPUT_POST, 'username');

if ($update) {
    // obter valores do form e colocar no $user
    $user->name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user->district = filter_input(INPUT_POST, 'district', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user->sexuality = filter_input(INPUT_POST, 'sexuality', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user->orientation = filter_input(INPUT_POST, 'orientation');
    $user->discord = filter_input(INPUT_POST, 'discord', FILTER_SANITIZE_URL);
    $user->instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_URL);
    $user->description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user->update();
}

?>

<main class="container bg-azul p-3">
    <div class="d-flex conteudo-perfil">
        <?php
        if ($user->profilepicture == null) {
            $url = WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';
        } else {
            $url = $user->profilepicture;
        }
        ?>
        <!-- Form Update foto de perfil -->
        <div class="col">
            <form method="post" enctype="multipart/form-data" action="?m=perfil&a=updateFoto">
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
                    <!-- Linha 1: Nome, Idade, Distrito -->
                    <div class="row mb-3 mx-3">
                        <div class="col me-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="username" value="<?= $user->name ?>">
                        </div>
                        <div class="col">
                            <label for="distrito" class="form-label">Distrito</label>
                            <input type="text" class="form-control" name="district" value="<?= $user->district ?>">
                        </div>
                    </div>

                    <!-- Linha 2: Gênero e Orientação -->
                    <div class="row mb-3 mx-3">
                        <div class="col me-3">
                            <label for="genero" class="form-label">Género</label>
                            <input type="text" class="form-control" name="sexuality" value="<?= $user->sexuality ?>">
                        </div>
                        <div class="col">

                            <label for="orientacao" class="form-label">Orientação</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $user->orientation ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php $lista->read($user); ?>
                                </ul>
                            </div>

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
                            <br>
                            <span class="badge bg-dark">Smite</span>
                            <span class="badge bg-dark">League of Legends</span>
                            <span class="badge bg-dark">Minecraft</span>
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
    <div>
        <?= $html ?>
        <?= debug() ? $_DEBUG : '' ?>
    </div>

</main>