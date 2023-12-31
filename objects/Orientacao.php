<?php

class Orientacao
{

    // Ligação à Base de Dados e nome da tabela
    private $conn;
    private $table_name = "ORIENTACAO";
    // Propriedades
    public $id;
    public $orientation;

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

        if ($user->orientation === null) {
            echo '<option value="" selected></option>';
        }

        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            if ($row->ORIENTACAO == $user->orientation) {
                echo '<option value="' . $row->ORIENTACAO . '" selected>' . $row->ORIENTACAO . '</option>';
            } else {
                echo '<option value="' . $row->ORIENTACAO . '" >' . $row->ORIENTACAO . '</option>';
            }
        }
    }
}
