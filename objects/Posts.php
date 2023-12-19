<?php

class Posts
{

    // Ligação à Base de Dados e nome da tabela
    private $conn;
    private $table_name = "POSTS";
    // Propriedades
    public $id;
    public $content;
    public $id_owner;

    // Método construtor que instancia a ligação à Base de Dados

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ler todos os posts e apresentar Admin
    function readAll()
    {
        // Query SQL para ler apenas um registo
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY CONTEUDO DESC";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        //Executar query
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo '<form method="post" action="?m=noticias&a=deletePost">
                        <input type="hidden" name="post_id" value="' . $row['ID'] . '">
                        <input type="hidden" name="conteudo" value="' . $row['CONTEUDO'] . '">
                        <div class="p-3">
                            <div class="mb-3">
                                <button type="submit" name="deletePost" class="btn btn-danger" value="Upload">Excluir</button>
                            </div>
                            <img class="img-fluid" src="' . WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_POSTS . $row['CONTEUDO'] . '">
                        </div>
                    </form>';
            }

        } else {
            echo '<p>Não há posts neste momento!.</p>';
        }
    }

    function readAllUser()
    {
        // Query SQL para ler apenas um registo
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY CONTEUDO ASC";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        //Executar query
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo '<div class="p-3">
                        <img class="img-fluid" src="' . WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_POSTS . $row['CONTEUDO'] . '">
                    </div>';          
            }

        } else {
            echo '<p>Não há posts neste momento!.</p>';
        }
    }
}
