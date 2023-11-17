<?php
define('DESC', 'Listar tabelas de uma Bases de Dados');
define('UC', 'PAW');

require_once './config.php';

require_once './core.php';
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
            
            <?php
            $html = '';
            debug('<p>Utilizador: <code>' . $db['username'] . '</code> Base de Dados: <code>' . $db['dbname'] . '</code></p>');
            $pdo = connectDB($db);

            $sql = "SHOW TABLES;";
            debug("SQL: $sql<br>");
            try {
                # Executar query
                $stm = $pdo->query($sql, PDO::FETCH_BOTH);
            } catch (PDOException $e) {
                die('PDOException: ' . $e->getCode() . ' - ' . $e->getMessage());
            }

            $html .= '<table class="table table-striped">';
            $html .= '<thead><tr><th>#</th><th>Tabela</th></tr></thead><tbody>';

            if ($stm->rowCount()===0){
                $html .= '<tr><td colspan="2">Nenhuma informação a apresentar</td></tr>';
            }else {
                $i = 0;

                while ($row = $stm->fetch()){
                    $html .= '<tr><td>' . ++$i . '<tr><td>' . $row[0] . '<tr><td>';
                    debug('Table: ' . print_r($row,true) . '<br>');
                }
            }
            # ...
            $html .= '</tbody></table>';
            
            echo $html;
            ?>
            
        </div>
        <?= debug() ? '<hr><div class="debug"><code>' . $_DEBUG . '</code></div> ' : '' ?>        
    </body>
</html>