<?php
require_once './objects/Usuarios.php';
$pdo = connectDB($db);
$user = new Usuarios($pdo);
$user->id = $_SESSION['uid'];

require_once './config.php';
require_once './core.php';

$html = '';

function slugify($text = '')
{
    if ($text != '') {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        return $text;
    }
    return FALSE;
}

$sql = "SELECT FOTO_PERFIL FROM `USUARIOS` WHERE ID = :ID LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":ID", $user->id);
$stmt->execute();
$foto = $stmt->fetch()['FOTO_PERFIL'];

// Apagar
//if ($foto != null) {
//    if (file_exists($foto)) {
//    }
//}
//if ($foto == null) {

    $upload_name = 'user' . $user->id;
    debug( "Upload name: " . $upload_name . "\n");

    $upload_extension = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    debug( "Upload extension: " . $upload_extension . "\n");

    $upload_type = $_FILES["fileToUpload"]["type"];
    debug( "Upload type: " . $upload_type . "\n");

    $upload_tmp_name = $_FILES["fileToUpload"]["tmp_name"];
    debug( "Upload tmp_name: " . $upload_tmp_name . "\n");

    $upload_error = $_FILES["fileToUpload"]["error"];
    debug( "Upload error: " . $upload_error . "\n");

    $upload_size = $_FILES["fileToUpload"]["size"];
    debug( "Upload size: " . $upload_size . "\n");

    $filename = UPLOAD_PATH . UPLOAD_FOTOS . slugify($upload_name) . '.' . $upload_extension;
    $fileBd = slugify($upload_name) . '.' . $upload_extension;

    //estava $filename em $fileBd
    $sqlUpdate = "UPDATE `USUARIOS` SET FOTO_PERFIL = :FOTO_PERFIL WHERE ID = :ID";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindValue(":FOTO_PERFIL", $fileBd);
    $stmtUpdate->bindValue(":ID", $user->id);
    $stmtUpdate->execute();

    //if (is_file($filename) || is_dir($filename)) {
    //    debug( "File already exists on server: " . $filename . "\n";
    //    $html .= '<div class="alert alert-error">Ficheiro já existe: <b>' . $filename . '</b></div>';
    //} else {
    if (@move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filename)) {
        debug( "New file uploaded: " . $filename . "\n");
        $html .= '<div class="alert alert-success">Ficheiro enviado com sucesso: <b>' . $filename . '</b></div>';
    } else {
        debug( "Error: " . error_get_last() . "\n");
        die();
    }
    
    //}
//}
