<?php

class Distritos
{

    // Ligação à Base de Dados e nome da tabela
    private $conn;
    private $table_name = "DISTRITOS";
    // Propriedades
    public $id;
    public $district;

    // Método construtor que instancia a ligação à Base de Dados

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ler dados tabela para perfil
    function read($user)
    {
        // Query SQL para ler apenas um registo
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY ID ASC";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        //Executar query
        $stmt->execute();

        if ($user->district === null) {
            echo '<option value="" selected></option>';
        }

        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            if ($row->DISTRITO == $user->district) {
                echo '<option value="' . $row->DISTRITO . '" selected>' . $row->DISTRITO . '</option>';
            } else {
                echo '<option value="' . $row->DISTRITO . '" >' . $row->DISTRITO . '</option>';
            }
        }
    }
}
