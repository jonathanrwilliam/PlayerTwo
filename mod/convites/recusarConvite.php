<?php
require_once './objects/Usuarios.php';
$pdo = connectDB($db);


require_once './config.php';
require_once './core.php';

$html = '';

$id_remetente = filter_input(INPUT_POST,"id_remetente",FILTER_SANITIZE_NUMBER_INT);
$id_recetor = $_SESSION['uid'];

//Atualizar a coluna ACEITE da tabela CONVITES
$sql = "DELETE FROM `CONVITES`
        WHERE ID_REMETENTE = :ID_REMETENTE AND ID_RECETOR = :ID_RECETOR";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":ID_REMETENTE", $id_remetente,PDO::PARAM_INT);
$stmt->bindValue(":ID_RECETOR", $id_recetor,PDO::PARAM_INT);
$stmt->execute();

if($stmt){
    $html .= '<div class="alert alert-success">Convite recusado!</div>';
}else{
    $html .= '<div class="alert alert-success">Falha ao recusar!</div>';
}
    

