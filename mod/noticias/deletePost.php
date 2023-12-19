<?php
require_once './objects/Usuarios.php';
$pdo = connectDB($db);
$user = new Usuarios($pdo);
$user->id = $_SESSION['uid'];

require_once './config.php';
require_once './core.php';

$html = '';

// Identificar o post através do id recebido
$post_id = filter_input(INPUT_POST,"post_id",FILTER_SANITIZE_NUMBER_INT);

if ($post_id !== "") {
    // Identificar o nome do ficheiro do post
    $post_name = $_POST["conteudo"];
    // Caminho completo ficheiro
    $file_path = UPLOAD_PATH . UPLOAD_POSTS . $post_name;

    // Excluir a imagem do servidor
    if (file_exists($file_path) && unlink($file_path)) {
        // Se a exclusão do arquivo foi bem-sucedida, procede para a exclusão no banco de dados
        $sqlDelete = "DELETE FROM `POSTS` WHERE ID = :post_id";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->bindValue(":post_id", $post_id);

        if ($stmtDelete->execute()) {
            debug("Post excluído! " . $file_path . "\n");
            $html .= '<div class="alert alert-success">Post excluído com sucesso!</div>';

        } else {
            debug("Erro ao excluir post no banco de dados.");
            $html .= '<div class="alert alert-danger">erro ao excluir do banco de dados</div>';
            echo $html;
        }
    } else {
        debug("Erro ao excluir imagem do servidor.");
        $html .= '<div class="alert alert-danger">erro ao excluir do servidor</div>';
        echo $html;
    }
} else {
    // Erro no envio do post
    debug("Erro ao enviar formulário.");
}
