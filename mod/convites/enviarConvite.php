<?php
require_once './objects/Usuarios.php';
$pdo = connectDB($db);


require_once './config.php';
require_once './core.php';

$html = '';

$id_recetor = filter_input(INPUT_POST,"id_recetor",FILTER_SANITIZE_NUMBER_INT);

//Inserir na bd
$sql = "INSERT INTO `CONVITES` (ID_REMETENTE,ID_RECETOR) VALUES (:ID_REMETENTE,:ID_RECETOR)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":ID_REMETENTE", $_SESSION['uid'],PDO::PARAM_INT);
$stmt->bindValue(":ID_RECETOR", $idTerceiro,PDO::PARAM_INT);
$stmt->execute();

if($stmt){
    $html .= '<div class="alert alert-success">Convite enviado!</div>';
}else{
    $html .= '<div class="alert alert-success">Falha no envio!</div>';
}
    

