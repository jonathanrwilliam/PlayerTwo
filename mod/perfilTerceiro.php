
<main class="container bg-azul p-3">
    <div class="d-flex conteudo-perfil">
        <div class="mx-auto mb-3 mb-md-0 fotoPerfil col-4"></div>
        <div class="container px-0">
            <!-- Linha 1: Nome, Idade, Distrito -->
            <div class="row mb-3 mx-3">
                <div class="col me-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" value="Ana" readonly>
                </div>
                <div class="col">
                    <label for="distrito" class="form-label">Distrito</label>
                    <input type="text" class="form-control" id="distrito" value="Lisboa" readonly>
                </div>
            </div>

            <!-- Linha 2: Gênero e Orientação -->
            <div class="row mb-3 mx-3">
                <div class="col me-3">
                    <label for="genero" class="form-label">Género</label>
                    <input type="text" class="form-control" id="genero" value="Mulher" readonly>
                </div>
                <div class="col">
                    <label for="orientacao" class="form-label">Orientação</label>
                    <input type="text" class="form-control" id="orientacao" value="Hétero" readonly>
                </div>
            </div>

            <!-- Linha 3: Links -->
            <div class="row mb-3 mx-3">
                <div class="col me-3">
                    <label for="genero" class="form-label">Discord</label>
                    <input type="text" class="form-control" id="discord" value="https://discord.com/servers" readonly>
                </div>
                <div class="col">
                    <label for="orientacao" class="form-label">Intagram</label>
                    <input type="text" class="form-control" id="instagram" value="https://www.instagram.com/" readonly>
                </div>
            </div>

            <!-- Linha 4: Descrição -->
            <div class="row mb-3 mx-3">
                <div class="col">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="4" readonly>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam dolorum nam nihil quia. Placeat blanditiis, consequuntur veniam nihil dolorum fugiat molestias aliquam dicta sed alias iusto explicabo quasi? Nisi, magni.</textarea>
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
                    <button type="button" class="btn btn-secondary">Sair</button>
                </div>
            </div>
        </div>

    </div>

</main>