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
        // Query SQL para ler apenas um registo
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE ID = :ID
            LIMIT 0,1";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar e associar valor do ID
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $stmt->bindValue(':ID', $this->id);

        //Executar query
        $stmt->execute();

        // Obter dados do registo e instanciar o objeto
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['NOME'];
        $this->dateofbirth = $row['DATA_NASCIMENTO'];
        $this->email = $row['EMAIL'];
        $this->password = $row['SENHA'];
        //Calcular idade / Verificar se está correto
        $currentDate = new DateTime();
        $this->age = $currentDate->diff(new DateTime($this->dateofbirth))->y;

        $this->description = $row['DESCRICAO'];
        $this->sexuality = $row['SEXO_GENERO'];
        $this->orientation = $row['ORIENTACAO_ORIENTACAO'];
        $this->district = $row['DISTRITO_DISTRITOS'];
        $this->profilepicture = $row['FOTO_PERFIL'];
        $this->discord = $row['LINK_DISCORD'];
        $this->instagram = $row['LINK_INSTAGRAM'];
    }

    // Atualizar dados perfil
    function update()
    {

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                NOME = :name,
                DISTRITO_DISTRITOS = :district,
                SEXO_GENERO = :sexuality,
                ORIENTACAO_ORIENTACAO = :orientation,
                LINK_DISCORD = :discord,
                LINK_INSTAGRAM = :instagram,
                DESCRICAO = :description
            WHERE
                ID = :id";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        // Filtrar valores
        $this->name = filter_var($this->name, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->district = filter_var($this->district, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->sexuality = filter_var($this->sexuality, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->orientation = filter_var($this->orientation, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->discord = filter_var($this->discord, FILTER_SANITIZE_URL);
        $this->instagram = filter_var($this->instagram, FILTER_SANITIZE_URL);
        $this->description = filter_var($this->description, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

        // Associar valores
        $stmt->bindValue(":name", $this->name);
        $stmt->bindValue(":district", $this->district);
        $stmt->bindValue(":sexuality", $this->sexuality);
        $stmt->bindValue(":orientation", $this->orientation);
        $stmt->bindValue(":discord", $this->discord);
        $stmt->bindValue(":instagram", $this->instagram);
        $stmt->bindValue(":description", $this->description);
        $stmt->bindValue(":id", $this->id);

        // Executar query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
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

        // Validar dados 
        $errors = false;

        if (empty($dateofbirth)) {
            $html .= '<div class="alert alert-danger">A data de nascimento é obrigatória.</div>';
            $errors = true;
        } else {
            // Calcular a idade com base na data de nascimento
            $date = new DateTime($dateofbirth);
            $today = new DateTime();
            $age = $today->diff($date)->y;
        
            // Verificar se o usuário tem pelo menos 18 anos
            if ($age < 18) {
                $html .= '<div class="alert alert-danger">Precisa ter pelo menos 18 anos.</div>';
                $errors = true;
            }
        }

        if ($discord == '') {
            $html .= '<div class="alert alert-danger">Precisa inserir seu discord.</div>';
            $errors = true;
        }
        if ($name == '') {
            $html .= '<div class="alert alert-danger">Tem que inserir um nome.</div>';
            $errors = true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $html .= '<div class="alert alert-danger">O email não é válido.</div>';
            $errors = true;
        }
        if (strlen($password) < 8) {
            $html .= '<div class="alert alert-danger">A senha precisa ter mais que 8 caracteres.</div>';
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
            $sql = "INSERT INTO `USUARIOS` (NOME, DATA_NASCIMENTO,EMAIL,SENHA,LINK_DISCORD) VALUES(:USERNAME,:DATA_NASCIMENTO,:EMAIL,:PASSWORD,:LINK)";
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

    // Fazer login Web
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


    // Ler todos para mostrar nos cards de perfil, aplica filtros de idade
    function readAll($user, $idadeMin, $idadeMax)
    {

        $dataAtual = new DateTime();

        $dataMin = $dataAtual->sub(new DateInterval('P' . $idadeMin . 'Y'))->format('Y-m-d');

        $dataAtual = new DateTime();

        // Calcular dataMax subtraindo $idadeMax anos da data atual
        $dataMax = $dataAtual->sub(new DateInterval('P' . $idadeMax . 'Y'))->format('Y-m-d');


        // Query SQL para ler todos os registos
        $query = "SELECT * FROM " . $this->table_name . " WHERE DATA_NASCIMENTO <= '" . $dataMin . "' AND DATA_NASCIMENTO >= '" . $dataMax . "'";

        // Preparar query
        $stmt = $this->conn->prepare($query);

        //Executar query
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['ADM'] == true || $row['ID'] == $user->id) {
                continue;
            } else {

                $currentDate = new DateTime();
                $data = $row['DATA_NASCIMENTO'];
                $age = $currentDate->diff(new DateTime($data))->y;

                $foto = ($row['FOTO_PERFIL'] !== null) ? WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $row['FOTO_PERFIL'] : WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';


                echo '<div class="card w-100 text-black border bg-cinza p-3 my-2">';
                echo '<div class="row no-gutters">';
                echo '<div class="col-md-3 col-12 text-center">';
                echo '<a href="index.php?m=perfil&a=perfilTerceiro&id=' . $row['ID'] . '" target="_blank">';
                echo '<img src="' . $foto . '" class="card-img-top cards-perfil-foto"></a>';
                echo '</div>';
                echo '<div class="col-md-9">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title fw-bold">' . $row['NOME'] . '&nbsp;&nbsp;<span class="badge bg-azul">Idade: ' . $age . '</span></h5>';
                echo '<p class="card-text">' . $row['DESCRICAO'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}
