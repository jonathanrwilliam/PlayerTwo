<?php

class Convites
{

    // Ligação à Base de Dados e nome da tabela
    private $conn;
    private $table_name = "CONVITES";
    // Propriedades
    public $id;
    public $id_remetente;
    public $id_recetor;

    // Método construtor que instancia a ligação à Base de Dados

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ler convites enviados conforme id e mostrar
    function readEnviados()
    {
        // Query SQL para ler todos os registos
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE ID_REMETENTE = :ID";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        //Executar query
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $id_recetor = $row['ID_RECETOR'];

                // Segunda query para obter o nome do remetente
                $queryRecetor = "SELECT * FROM USUARIOS WHERE ID = :ID_RECETOR";

                // Preparar a segunda query
                $stmtRecetor = $this->conn->prepare($queryRecetor);

                // Filtrar e associar valor do ID_REMETENTE
                $id_recetor = filter_var($id_recetor, FILTER_SANITIZE_NUMBER_INT);
                $stmtRecetor->bindValue(':ID_RECETOR', $id_recetor);

                // Executar a segunda query
                $stmtRecetor->execute();

                while ($row = $stmtRecetor->fetch(PDO::FETCH_ASSOC)) {

                    $currentDate = new DateTime();
                    $data = $row['DATA_NASCIMENTO'];
                    $age = $currentDate->diff(new DateTime($data))->y;

                    $foto = ($row['FOTO_PERFIL'] !== null) ? WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $row['FOTO_PERFIL'] : WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';


                    echo '<div class="card bg-dark border-light my-2">
                    <div class="card-body d-flex">
                        <div class="col-4 text-center me-2">
                            <a href="index.php?m=perfil&a=perfilTerceiro&id=' . $row['ID'] . '"target="_blank">
                            <img src="' . $foto . '" class="card-img-top cards-convites-foto">
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="row text-center mb-1">
                                <h5 class="card-title fw-bold d-flex justify-content-center align-items-center"><a href="perfilTerceiro.html" target="_blank" class="text-decoration-none text-light">' . $row['NOME'] . '</a>
                                    &nbsp;&nbsp;<span class="badge bg-azul">Idade:' . $age . '</span></h5>
                            </div>
                            <div class="d-flex justify-content-center text-center">
                                <form action="?m=home&a=home" method="post">
                                    <input type="hidden" name="id_recetor" value="' . $row['ID'] . '">
                                    <button type="submit" name="cancelar" value="cancelar" class="btn btn-danger flex-fill btn-sm" id="cancelar">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            }
        } else {
            echo '<p>Não há convites enviados.</p>';
        }
    }

    // Ler convites recebidos conforme id e mostrar
    function readRecebidos()
    {
        // Query SQL para ler todos os registos
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE ID_RECETOR = :ID AND ACEITE = 0";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        //Executar query
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $id_remetente = $row['ID_REMETENTE'];

                // Segunda query para obter o nome do remetente
                $queryRemetente = "SELECT * FROM USUARIOS WHERE ID = :ID_REMETENTE";

                // Preparar a segunda query
                $stmtRemetente = $this->conn->prepare($queryRemetente);

                // Filtrar e associar valor do ID_REMETENTE
                $id_remetente = filter_var($id_remetente, FILTER_SANITIZE_NUMBER_INT);
                $stmtRemetente->bindValue(':ID_REMETENTE', $id_remetente);

                // Executar a segunda query
                $stmtRemetente->execute();

                while ($row = $stmtRemetente->fetch(PDO::FETCH_ASSOC)) {

                    $currentDate = new DateTime();
                    $data = $row['DATA_NASCIMENTO'];
                    $age = $currentDate->diff(new DateTime($data))->y;

                    $foto = ($row['FOTO_PERFIL'] !== null) ? WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $row['FOTO_PERFIL'] : WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';


                    echo '<div class="card bg-dark border-light my-2">
                    <div class="card-body d-flex">
                        <div class="col-4 text-center me-2">
                            <a href="index.php?m=perfil&a=perfilTerceiro&id=' . $row['ID'] . '"target="_blank">
                            <img src="' . $foto . '" class="card-img-top cards-convites-foto">
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="row text-center mb-1">
                                <h5 class="card-title fw-bold d-flex justify-content-center align-items-center"><a href="perfilTerceiro.html" target="_blank" class="text-decoration-none text-light">' . $row['NOME'] . '</a>
                                    &nbsp;&nbsp;<span class="badge bg-azul">Idade:' . $age . '</span></h5>
                            </div>
                            <div class="d-flex justify-content-center text-center">
                                <form action="?m=home&a=home" method="post">
                                    <input type="hidden" name="id_remetente" value="' . $row['ID'] . '">
                                    <button type="submit" name="aceitar" value="aceitar" class="btn btn-success flex-fill me-1 btn-sm" id="aceitar">Aceitar</button>
                                </form>
                                <form action="?m=home&a=home" method="post">
                                    <input type="hidden" name="id_remetente" value="' . $row['ID'] . '">
                                    <button type="submit" name="recusar" value="recusar" class="btn btn-danger flex-fill btn-sm" id="recusar">Recusar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            }
        } else {
            echo '<p>Não há convites recebidos.</p>';
        }
    }

    // Método para verificar se o usuário já enviou um convite a essa pessoa
    //Utilizado em perfilTerceiro
    function verificarConvite($id_remetente, $id_recetor)
    {

        $query = "SELECT COUNT(*) as count FROM CONVITES 
                  WHERE (ID_REMETENTE = :id_remetente OR ID_REMETENTE = :id_recetor) 
                  AND (ID_RECETOR = :id_remetente OR ID_RECETOR = :id_recetor)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_remetente', $id_remetente, PDO::PARAM_INT);
        $stmt->bindParam(':id_recetor', $id_recetor, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    // Método para verificar se existe um convite aceite entre os usuarios
    //Utilizado em perfilTerceiro
    function verificarAceite($id_remetente, $id_recetor)
    {

        $query = "SELECT COUNT(*) as count FROM CONVITES 
                  WHERE (ID_REMETENTE = :id_remetente OR ID_REMETENTE = :id_recetor) 
                  AND (ID_RECETOR = :id_remetente OR ID_RECETOR = :id_recetor)
                  AND ACEITE = 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_remetente', $id_remetente, PDO::PARAM_INT);
        $stmt->bindParam(':id_recetor', $id_recetor, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    // Método para verificar todos os convites com ACEITE = true e mostrar dados em Conversas
    //Utilizado em home na parte conversas
    function readConversas()
    {

        $query = "SELECT * FROM CONVITES 
                  WHERE (ID_REMETENTE = :ID 
                  OR ID_RECETOR = :ID)
                  AND ACEITE = 1";

        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num >0){

            while ($row = $stmt->fetch()){
                $idRemetente = $row['ID_REMETENTE'];
                $idRecetor = $row['ID_RECETOR'];

                if ($idRemetente == $this->id) {
                    $idUsuario = $idRecetor;
                } else {
                    // Se o ID_RECETOR for igual a $this->id
                    $idUsuario = $idRemetente;
                }

                // Obter dados do terceiro
                $queryUsuario = "SELECT * FROM USUARIOS WHERE ID = :ID";
                $stmtUsuario = $this->conn->prepare($queryUsuario);
                $stmtUsuario->bindValue(':ID', $idUsuario, PDO::PARAM_INT);
                $stmtUsuario->execute();

                $rowUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

                $fotoUsuario = ($rowUsuario['FOTO_PERFIL'] !== null) ? WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $rowUsuario['FOTO_PERFIL'] : WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';

                $nomeUsuario = $rowUsuario['NOME'];
                $discordUsuario = $rowUsuario['LINK_DISCORD'];
                $instagramUsuario = $rowUsuario['LINK_INSTAGRAM'];


                echo'<div class="card bg-dark border-light my-2">
                        <div class="card-body d-flex">
                            <div class="col-4 text-center me-2 d-flex align-items-center">
                                <a href="index.php?m=perfil&a=perfilTerceiro&id=' . $rowUsuario['ID'] . '"target="_blank">
                                <img src="' . $fotoUsuario .'" class="card-img-top cards-conversas-foto">
                                </a>
                            </div>
                            <div class="col-8">
                                <div class="text-center">
                                    <h5 class="card-title fw-bold d-flex justify-content-center align-items-center mb-3">' . $nomeUsuario . '</h5>
                                    <p class="bg-azul border rounded-p" id="msg">' . $discordUsuario . '</p>
                                </div>
                                <div class="text-center">
                                    <p class="bg-azul border rounded-p" id="msg">' . $instagramUsuario . '</p>
                                </div>
                            </div>
                        </div>
                    </div>';

            }

        }else{
            echo '<p>Não há conversas.</p>';
        }

    }


}
