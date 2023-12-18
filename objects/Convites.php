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

    // Ler convites recebidos conforme id e mostrar
    function readRecebidos()
    {
        // Query SQL para ler todos os registos
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE ID_RECETOR = :ID";

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
                            <a href="perfilTerceiro.php" target="_blank">
                            <img src="' . $foto . '" class="card-img-top cards-convites-foto">
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="row text-center mb-1">
                                <h5 class="card-title fw-bold d-flex justify-content-center align-items-center"><a href="perfilTerceiro.html" target="_blank" class="text-decoration-none text-light">' . $row['NOME'] . '</a>
                                    &nbsp;&nbsp;<span class="badge bg-azul">Idade:' . $age . '</span></h5>
                            </div>
                            <div class="d-flex justify-content-center text-center">
                                <button type="button" class="btn btn-success flex-fill me-1 btn-sm" id="aceitar">Aceitar</button>
                                <button type="button" class="btn btn-danger flex-fill btn-sm" id="recusar">Recusar</button>
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
}
