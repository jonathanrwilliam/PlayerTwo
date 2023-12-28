<?php
// Carregar configurações
require_once '../../config.php';
require_once '../../core.php';

$pdo = connectDB($db);
// Carregar classe
require_once '../../objects/Usuarios.php';
$user = new Usuarios($pdo);

// Definição do cabeçalho
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Verificar se os dados de login foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obter dados de registo
    $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dateofbirth = filter_input(INPUT_POST, 'dateofbirth');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password =  filter_input(INPUT_POST, 'password');
    $password_hash_db = password_hash($password, PASSWORD_DEFAULT);
    $discord = filter_input(INPUT_POST, 'discord', FILTER_SANITIZE_URL);

    // Validar dados nome, email e passe
    $errors = false;
    if ($name == '') {
        echo json_encode(array("message" => "Inserir nome"));
        $errors = true;
    }
    if ($dateofbirth == '') {
        echo json_encode(array("message" => "Inserir data de nascimento"));
        $errors = true;
    }
    if ($discord == '') {
        echo json_encode(array("message" => "Inserir discord"));
        $errors = true;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("message" => "Email inválido"));
        $errors = true;
    }
    if (strlen($password) < 8) {
        echo json_encode(array("message" => "Senha precisa conter mais de 8 caracteres"));
        $errors = true;
    }

    // Verificar se email já está registado
    $sql = "SELECT id FROM USUARIOS WHERE email = :EMAIL LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(array("message" => "Email já registado"));
        $errors = true;
    }

    // Fazer o registo do usuário na BD
    if (!$errors) {
        $sql = "INSERT INTO `USUARIOS` (NOME, DATA_NASCIMENTO,EMAIL,SENHA,LINK_DISCORD) VALUES(:USERNAME,:DATA_NASCIMENTO,:EMAIL,:PASSWORD,:LINK)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":USERNAME", $name, PDO::PARAM_STR);
        $stmt->bindValue(":DATA_NASCIMENTO", $dateofbirth, PDO::PARAM_STR);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->bindValue(":PASSWORD", $password_hash_db, PDO::PARAM_STR);
        $stmt->bindValue(":LINK", $discord, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(array("message" => "Registado com sucesso"));
        } else {
            echo json_encode(array("message" => "Erro ao registar"));
        }
    }

}
