<?php
define('DESC', 'Informações de um servidor de Bases de Dados');
define('UC', 'PAW');
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= UC ?> | <?= DESC ?> | <?= AUTHOR ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <code><?= DESC ?></code>
        <?php
        # Incluir config
        require_once './config.php';
        require_once './core.php';
        
        # Criar ligação à BD
        try {
            $pdo = new PDO(
                'mysql:host=' . $db['host'] . ';' .
                'port=' . $db['port'] . ';' .
                'charset=' . $db[ 'charset'] . ';' .
                'dbname=' . $db['dbname'] . ';' ,
                $db['username'],
                $db['password']
            );
        } catch (PDOException $e) {
            die('Erro ao ligar ao servidor ' . $e->getMessage());
        }
        debug('Ligação à BD efetuada com o utilizador: ' . $db['username'].'<br>');
        ?>
        <p>Utilizador: <code><b><?= $db['username']?></b></code></p>
        <p>MySQL Server: <b><?= $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) ?></b></p>
        <p>Version: <b><?= $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) ?></b></p>
        <p>Status: <b><?= $pdo->getAttribute(PDO::ATTR_SERVER_INFO) ?></b></p>
        <p>Driver utilizado: <b><? $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) ?></b></p>
        <p> Versão do Cliente: <b><?= $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) ?></b></p>

        <?= debug() ? '<hr><div class="debug"><code>'. $_DEBUG .'</code></div> ' : '' ?>        
    </body>
</html>