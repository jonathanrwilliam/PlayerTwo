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
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query = "SELECT * FROM USUARIOS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();

    //Verifica se existe resultados
    if ($num > 0) {

        $users_arr = array();
        $users_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['ADM'] == true) {
                continue;
            } else {

                $currentDate = new DateTime();
                $data = $row['DATA_NASCIMENTO'];
                $age = $currentDate->diff(new DateTime($data))->y;

                $descricao = ($row['DESCRICAO'] !== null) ? $row['DESCRICAO'] : '';

                $genero = ($row['SEXO_GENERO'] !== null) ? $row['SEXO_GENERO'] : '';

                $orientacao = ($row['ORIENTACAO_ORIENTACAO'] !== null) ? $row['ORIENTACAO_ORIENTACAO'] : '';

                $distrito = ($row['DISTRITO_DISTRITOS'] !== null) ? $row['DISTRITO_DISTRITOS'] : '';

                $foto = ($row['FOTO_PERFIL'] !== null) ? WEB_SERVER . WEB_ROOT . UPLOAD_FOLDER . UPLOAD_FOTOS . $row['FOTO_PERFIL'] : WEB_SERVER . WEB_ROOT . 'Projeto/static/images/profile_avatar.jpg';

                $instagram = ($row['LINK_INSTAGRAM'] !== null) ? $row['LINK_INSTAGRAM'] : '';


                $user = array(
                    "nome" => $row['NOME'],
                    "idade" => $age,
                    "descricao" => $descricao,
                    "genero" => $genero,
                    "orientacao" => $orientacao,
                    "distrito" => $distrito,
                    "foto" => $foto,
                    "discord" => $row['LINK_DISCORD'],
                    "instagram" => $instagram
                );
                array_push($users_arr["records"], $user);
            }
        }
        //http_response_code(200);
        echo json_encode($users_arr);
    } else {
        //http_response_code(404);
        echo json_encode(array("message" => 'Nenhum registo encontrado.'));
    }
}
