<?php

class Usuarios
{

    // Ligação à Base de Dados e nome da tabela
    private $conn;
    private $table_name = "USUARIOS";
    // Propriedades
    public $id;
    public $name;
    public $dateofbirth;
    public $email;
    public $password;
    public $age;
    public $description;
    public $sexuality;
    public $orientation;
    public $district;
    public $profilepicture;
    public $discord;
    public $instagram;

    // Método construtor que instancia a ligação à Base de Dados

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ler dados perfil
    function readOne()
    {
    }

    // Ler dados dos cards
    function read()
    {
    }

    // Inserir novo usuário na BD
    function create()
    {

        $html = '';

        // Obter dados do Formulário
        $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateofbirth = filter_input(INPUT_POST, 'dateofbirth');
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password =  filter_input(INPUT_POST, 'password');
        $password_hash_db = password_hash($password, PASSWORD_DEFAULT);
        $discord = filter_input(INPUT_POST, 'discord', FILTER_SANITIZE_URL);

        // Validar dados nome, email e passe
        $errors = false;
        if ($name == '') {
            $html .= '<div class="alert alert-danger">Tem que inserir um nome.</div>';
            $errors = true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $html .= '<div class="alert alert-danger">O email não é válido.</div>';
            $errors = true;
        }
        if (strlen($password) < 8) {
            $html .= '<div class="alert alert-danger">A senha precisa ter entre 8 e 15 caracteres.</div>';
            $errors = true;
        }

        // Verificar se email já está registado
        $sql = "SELECT id FROM USUARIOS WHERE email = :EMAIL LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $html .= '<div class="alert alert-danger">O email indicado já se encontra registado</div>';
            $errors = true;
        }

        // Fazer o registo do usuário na BD
        if (!$errors) {
            $sql = "INSERT INTO USUARIOS(NOME, DATA_NASCIMENTO,EMAIL,SENHA,LINK_DISCORD) VALUES(:USERNAME,:DATA_NASCIMENTO,:EMAIL,:PASSWORD,:LINK)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":USERNAME", $name, PDO::PARAM_STR);
            $stmt->bindValue(":DATA_NASCIMENTO", $dateofbirth, PDO::PARAM_STR);
            $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
            $stmt->bindValue(":PASSWORD", $password_hash_db, PDO::PARAM_STR);
            $stmt->bindValue(":LINK", $discord, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $html .= '<div class="alert alert-success">Utilizador criado com sucesso!</div>';
            } else {
                $html .= '<div class="alert alert-danger">Erro ao inserir</div>';
            }
        }
        return $html;
    }

    // Fazer login
    function login()
    {

        $html = '';
        
        $email = filter_input(INPUT_POST, 'loginEmail', FILTER_SANITIZE_EMAIL);
        $password =  filter_input(INPUT_POST, 'loginPassword');
        $password_hash_db = password_hash($password, PASSWORD_DEFAULT);
        debug("FORMULÁRIO:<br>email: $email <br> pwd: $password <br> hash: $password_hash_db<br>");

         //entra aqui
        $errors = false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $html .= '<div class="alert alert-danger">O email não é válido!</div>';
            $errors = true;
        }

        if (!$errors) {
            $sql = "SELECT * FROM `USUARIOS` WHERE `EMAIL`= :EMAIL LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
            $stmt->execute();
            //entra aqui
            if ($stmt->rowCount() != 1) {
                $html .= '<div class="acontainer alert-danger">O email não está registado!</div>';
                $errors = true;
            } else {
                $row = $stmt->fetch();
                $html .= debug('<b>BASE DE DADOS</b>:<br>id: ' . $row['ID'] . '<br> username: ' . $row['NOME'] . '<br> password: ' . $row['SENHA'] . '<br>');
            }
        }

        if (!$errors) {
            if (!password_verify($password, $row['SENHA'])) {
                $html .= '<div class="alert alert-danger">Palavra-passe incorreta.</div>';
                sleep(random_int(1, 3));
            } else {
                debug('<b>LOGIN OK</b><br>Registar variáveis de sessão<br>');
                $_SESSION['uid'] = $row['ID'];
                $_SESSION['email'] = $row['EMAIL'];
                $_SESSION['username'] = $row['NOME'];
                $_SESSION['admin'] = $row['ADM'];
                header('Location: index.php');
                //$html .= '<div class="alert alert-success">Login com sucesso! <br> <b>' . $_SESSION['username'] . '</b><br>';
                //$html .= '<a href="index.php" class="btn btn-primary">Continuar</a></div>';
            }
        }
        return $html;
    }



    // Atualizar dados perfil
    function update()
    {
    }

    // Remover um usuário
    function delete()
    {
    }
}
