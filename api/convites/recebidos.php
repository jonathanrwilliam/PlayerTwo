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

    $id_recetor = ($_POST['id']);

    $query = "SELECT * FROM CONVITES WHERE ID_RECETOR = :ID";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':ID', $id_recetor);
    $stmt->execute();
    $num = $stmt->rowCount();

    //Verifica se existe resultados
    if ($num > 0) {

        $recebidos_arr = array();
        $recebidos_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['ACEITE'] != true) {

                $id_remetente = $row['ID_REMETENTE'];

                $queryUsers = "SELECT * FROM USUARIOS WHERE ID = :ID";
                $stmtUsers = $pdo->prepare($queryUsers);
                $stmtUsers->bindValue(':ID', $id_remetente);
                $stmtUsers->execute();

                while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {

                    $currentDate = new DateTime();
                    $data = $row['DATA_NASCIMENTO'];
                    $age = $currentDate->diff(new DateTime($data))->y;

                    $foto = ($row['FOTO_PERFIL'] !== null) ? WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $row['FOTO_PERFIL'] : WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';

                    $user = array(
                        "nome" => $row['NOME'],
                        "idade" => $age,
                        "foto" => $foto
                    );
                    array_push($recebidos_arr["records"], $user);
                }
            }
        }
        //http_response_code(200);
        echo json_encode($recebidos_arr);
    } else {
        //http_response_code(404);
        echo json_encode(array("message" => 'Não há convites.'));
    }
}
