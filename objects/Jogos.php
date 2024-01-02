<?php

class Jogos
{

    // Ligação à Base de Dados e nome da tabela
    private $conn;
    private $table_name = "JOGOS";
    // Propriedades
    public $id;
    public $district;

    // Método construtor que instancia a ligação à Base de Dados

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ler os jogos do usuário para perfil
    function read($user)
    {
        // Query para selecionar jogos do usuario JOGOS_HAS_USUARIOS
        $query = "SELECT * FROM JOGOS_HAS_USUARIOS WHERE ID_USUARIO = :ID";

        // Preparar query
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ID', $user->id);

        //Executar query
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo '<span class="badge bg-dark">' . $row['JOGOS_JOGO'] . '</span>';
            }
        }
    }

    //Funcao para listar os jogos no perfil em um menu dropdown
    function list()
    {
        // Query SQL para ler apenas um registo
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY ID ASC";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        //Executar query
        $stmt->execute();


        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {

            echo '<option value="' . $row->JOGO . '" >' . $row->JOGO . '</option>';
        }
    }

    //Funcao para adicionar jogos 
    function addJogo($jogo){
        
        $id = $_SESSION['uid'];

         // Verificar se já existe esse jogo para este usuário
        $checkQuery = "SELECT COUNT(*) FROM `JOGOS_HAS_USUARIOS` WHERE JOGOS_JOGO = :JOGO AND ID_USUARIO = :ID";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindValue(":JOGO", $jogo, PDO::PARAM_STR);
        $checkStmt->bindValue(":ID", $id, PDO::PARAM_INT);
        $checkStmt->execute();
        $rowCount = $checkStmt->fetchColumn();

        if($rowCount == 0){

            $query = "INSERT INTO `JOGOS_HAS_USUARIOS` (JOGOS_JOGO,ID_USUARIO) VALUES (:JOGO,:ID)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":JOGO", $jogo,PDO::PARAM_STR);
            $stmt->bindValue(":ID", $id,PDO::PARAM_INT);
            $stmt->execute();

        }

    }

    function delJogo($jogo){

        $id = $_SESSION['uid'];

        $query = "DELETE FROM `JOGOS_HAS_USUARIOS`
        WHERE JOGOS_JOGO = :JOGO AND ID_USUARIO = :ID";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":JOGO", $jogo,PDO::PARAM_STR);
        $stmt->bindValue(":ID", $id,PDO::PARAM_INT);
        $stmt->execute();
        
    }
}
