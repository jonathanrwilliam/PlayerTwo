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



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se id foi recebido
    if (isset($_POST['id'])) {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $user->id = $id;
        $user->readOne();

        $user_arr = array(
            "id" => $user->id,
            "name" => $user->name,
            "dateofbirth" => $user->dateofbirth,
            "email" => $user->email,
            "age" => $user->age,
            "description" => $user->description,
            "sexuality" => $user->sexuality,
            "orientation" => $user->orientation,
            "district" => $user->district,
            "profilepicture" => $user->profilepicture,
            "discord" => $user->discord,
            "instagram" => $user->instagram
        );
        // Definir resposta - 200 OK
        http_response_code(200);
        // Enviar resposta
        echo json_encode($user_arr);

    } else {

        http_response_code(400); // Bad Request
        echo json_encode(array("message" => "Parâmetro 'id' não fornecido."));

    }
}

