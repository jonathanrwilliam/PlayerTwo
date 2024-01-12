<?php
// Carregar configurações
require_once '../../config.php';
require_once '../../core.php';

$pdo = connectDB($db);

// Definição do cabeçalho
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $query = "SELECT * FROM POSTS ORDER BY CONTEUDO DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();

    //Verifica se existe resultados
    if ($num > 0) {

        $posts_arr = array();
        $posts_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $img = WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_POSTS . $row['CONTEUDO'];

            $post = array(
                "foto" => $img
            );
            array_push($posts_arr["records"], $post);

        }
        //http_response_code(200);
        echo json_encode($posts_arr);
    } else {
        //http_response_code(404);
        echo json_encode(array("message" => 'Não há notícias.'));
    }
}
