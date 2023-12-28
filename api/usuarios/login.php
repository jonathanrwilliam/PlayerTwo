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
    // Obter dados de login
    $email = ($_POST['email']);
    $password = ($_POST['password']);


    $sql = "SELECT * FROM `USUARIOS` WHERE `EMAIL`= :EMAIL LIMIT 1";
    $pdo = connectDB($db);
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
    $stmt->execute();

    //Obter a linha resultante da consulta por email
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {

        // Email não encontrado - 404 not found
        //http_response_code(404);
        echo json_encode(array("message" => "Email não registado."));

    } elseif (!password_verify($password, $row['SENHA'])) {

        // Senha incorreta - 401 Unauthorized
        //http_response_code(401);
        echo json_encode(array("message" => "Senha incorreta."));

    } else {

        // Credenciais corretas - 200 OK
        http_response_code(200);
        echo json_encode(array("message" => "Login ok","id" => $row['ID']));

    }

}
