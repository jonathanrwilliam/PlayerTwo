<?php
define('DESC', 'Criar uma tabela numa tabela da Bases de Dados');
define('UC', 'PAW');
$html = '';

require_once './config.php';
require_once './core.php';

$pdo = connectDB($db);

debug('<p>Utilizador: <code>' . $db['username'] . '</code> Base de Dados: <code>' . $db['dbname'] . '</code></p>');

# Obter nome do formulário
$tableName = filter_input(INPUT_POST,'tableName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($tableName != '') {

    $sql = "CREATE TABLE `$tableName` (`ID` int NOT NULL AUTO_INCREMENT, 
                `NOME` varchar(100), PRIMARY KEY(`ID`) ) ENGINE=InnoDB DEFAULT 
                CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
    debug("SQL: $sql<br>");
    try {
        if ($pdo->query($sql)){
            $html .= '<div class="alert alert-success"><p>Tabela<b>' . $tableName . '</b> criada com sucesso.</p>';
        } else {
            $html .= '<div class= "alert alert-error"><p>Erro ao criar tabela <b>' . $tableName . '</b>.</p>';
            debug('PDO ERROR: ' .print_r($pdo->errorInfo(),true).'<br>');
        }
        # Ou erro  
    } catch (PDOException $e) {
        debug('PDOException: '.$e->getCode().' - '.$e->getMessage());
    }
} else {
    $html .= '<div class="alert alert-warning"><p>Erro ao criar tabela. Deve introduzir o nome da tabela.</p></div>';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?= UC . ' | ' . DESC . ' | ' . AUTHOR ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../common/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h3><?= DESC ?></h3>
            <div><?= $html ?></div>
            <div>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="tableName">Nova Tabela</label>
                        <br>
                        <input type="text" class="form-control" name="tableName" id="tableName" aria-describedby="tableNameHelp" placeholder="Introduza o nome da tabela">
                        <br>
                        <small id="tableNameHelp" class="form-text text-muted">Nome da tabela a criar</small>
                        <br>
                        <label for="codigo">Código de acesso</label>
                        <br>
                        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Introduza o código">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Criar">
                </form>
            </div>
        </div>
<?= debug() ? '<hr><div class="debug"><code>' . $_DEBUG . '</code></div> ' : '' ?>                
    </body>
</html>