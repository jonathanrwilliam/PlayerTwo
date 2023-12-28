<?php
require_once './objects/Usuarios.php';
require_once './objects/Convites.php';

$pdo = connectDB($db);

$listarUsuarios = new Usuarios($pdo);

$user->id = $_SESSION['uid'];

//O nome do objeto é convites recebidos mas serve para ler os recebidos, enviados e conversas
$convitesRecebidos = new Convites($pdo);
$convitesRecebidos->id = $_SESSION['uid'];

require_once './config.php';
require_once './core.php';

// Aceitar convite
$aceitarConvite = filter_input(INPUT_POST, 'aceitar');
if ($aceitarConvite) {
    require_once './mod/convites/aceitarConvite.php';
}

// Recusar convite
$aceitarConvite = filter_input(INPUT_POST, 'recusar');
if ($aceitarConvite) {
    require_once './mod/convites/recusarConvite.php';
}

// Cancelar convite
$cancelarConvite = filter_input(INPUT_POST, 'cancelar');
if ($cancelarConvite) {
    require_once './mod/convites/cancelarConvite.php';
}


?>
<div>
  <?= $html ?>
</div>
<main class=" container-fluid	">
  <div class="row vh-100">

    <!--Convites-->
    <div class="col-lg-3 bg-azul p-2 d-none d-lg-block convites" id="Convites">
      <div class="container-fluid px-0">
        <div>
          <p class="text-center bg-dark p-1 rounded-p mb-0"> CONVITES</p>
        </div>
        <div class="d-flex my-1">
          <button class="btn btn-dark flex-fill p-0 me-1" type="button" onclick="mostrarConteudo('enviados')">
            <p class="mb-0">Enviados</p>
          </button>
          <button class="btn btn-dark flex-fill p-0 ms-1" type="button" onclick="mostrarConteudo('recebidos')">
            <p class="mb-0">Recebidos</p>
          </button>
        </div>
      </div>

      <div id="conteudoEnviados" style="display:none;">
        <?php $convitesRecebidos->readEnviados(); ?>
      </div>

      <div id="conteudoRecebidos">
        <?php $convitesRecebidos->readRecebidos(); ?>
      </div>


    </div>

    <!--Principal-->
    <div class="col-12 col-lg-6 border-end border-start bg-dark border-3 p-2" id="Principal">
      <!--Filtros-->
      <container class="container-fluid px-0">
        <div class="d-flex border-bottom pb-1">
          <input class="w-100 text-center align-items-center campoIdade me-1" type="number" min="18" max="99" placeholder="Idade Mínima">
          <input class="w-100 text-center  campoIdade" type="number" min="18" max="99" placeholder="Idade Máxima">
          <!--Botão de busca-->
          <button class="btn btn-dark rounded-circle mx-1" id="buscaButton">
            <i class="bi-search fs-4"></i>
          </button>
          <!--Botão de filtro-->
          <button class="btn btn-dark rounded-circle mx-1" id="filtroButton">
            <i class="bi-funnel fs-4"></i>
          </button>
          <!--Idade-->

          <!--Género-->
          <div class="dropdown d-flex align-items-center align-items-stretch flex-fill">
            <button class="btn btn-secondary btn-sm mx-1 botoes dropdown-toggle flex-fill" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: none;">
              Género
            </button>
            <ul class="dropdown-menu">
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="homemCheckbox">
                  Homem
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="mulherCheckbox">
                  Mulher
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="homemTransCheckbox">
                  Homem trans
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="mulherTransCheckbox">
                  Mulher trans
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="naoBinarioCheckbox">
                  Não binário
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="outroGeneroCheckbox">
                  Outro
                  </label>
                </div>
              </li>
            </ul>
          </div>
          <!--Orientação-->
          <div class="dropdown d-flex align-items-center align-items-stretch flex-fill">
            <button class="btn btn-secondary btn-sm mx-1 botoes dropdown-toggle flex-fill" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: none;">
              Orientação
            </button>
            <ul class="dropdown-menu">
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="heteroCheckbox">
                  Hétero
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="gayCheckbox">
                  Gay
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="biCheckbox">
                  Bi
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="assexualCheckbox">
                  Assexual
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="pansexualCheckbox">
                  Pansexual
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="outroOrientacaoCheckbox">
                  Outro
                  </label>
                </div>
              </li>
            </ul>
          </div>
          <!--Distrito-->
          <div class="dropdown d-flex align-items-center align-items-stretch flex-fill">
            <button class="btn btn-secondary btn-sm mx-1 botoes dropdown-toggle flex-fill" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: none;">
              Distrito
            </button>
            <ul class="dropdown-menu">
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="heteroCheckbox">
                  Aveiro
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="gayCheckbox">
                  Beja
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="biCheckbox">
                  Braga
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="assexualCheckbox">
                  Bragança
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="pansexualCheckbox">
                  Castelo Branco
                  </label>
                </div>
              </li>
              <li>
                <div class="form-check ms-1">
                  <input class="form-check-input" type="checkbox" id="outroOrientacaoCheckbox">
                  Coimbra
                  </label>
                </div>
              </li>
            </ul>
          </div>
          <!--Jogos-->
          <button class="btn btn-secondary btn-sm flex-fill mx-1 botoes" type="button" id="btnJogos" style="display: none;">
            Jogos
          </button>
        </div>
      </container>

      <!-- Cards filtros jogos-->
      <div class="container px-0 mb-3" id="Cards" style="overflow-x: auto; overflow-y: hidden; display: none;">

        <div class="d-flex py-1 mt-2 align-items-center" id="lista">

          <div class="card cards-jogos mx-1">
            <img src="https://s1.mmommorpg.com/media/wide/smite-wide.jpg" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title text-center">Smite</h5>
            </div>
          </div>
          <div class="card cards-jogos mx-1">
            <img src="https://fraglider.pt/wp-content/uploads/2022/05/leagueoflegends_wall1.jpg" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title text-center">League of legends</h5>
            </div>
          </div>
          <div class="card cards-jogos mx-1">
            <img src="https://fraglider.pt/wp-content/uploads/2022/05/leagueoflegends_wall1.jpg" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title text-center">League of legends</h5>
            </div>
          </div>
          <div class="card cards-jogos mx-1">
            <img src="https://fraglider.pt/wp-content/uploads/2022/05/leagueoflegends_wall1.jpg" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title text-center">League of legends</h5>
            </div>
          </div>

        </div>

      </div>


      <!-- Cards perfil -->
      <? $listarUsuarios->readAll($user); ?>

    </div>


    <!--Conversas-->
    <div class="col-lg-3 bg-azul p-2 d-none d-lg-block conversas" id="Conversas">
      <div class="container-fluid px-0">
        <p class="text-center bg-dark p-1 rounded-p mb-0"> CONVERSAS</p>
        <form class="d-flex my-1" role="search">
          <input class="form-control p-1 bg-light bg-opacity-25 pb-0" type="search" placeholder="Buscar" aria-label="Search">
        </form>
      </div>
      <!--Cards emails-->
      <?php $convitesRecebidos->readConversas(); ?>
    </div>
</main>