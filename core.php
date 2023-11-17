<?php

/* Descrição: Funções core da aplicação
 * Autor: Mário Pinto
 * 
 */

/**
 * Cria uma ligação a uma base de dados e devolve um objeto PDO com a ligação
 * @param Array $db 
 *        Array com definição de host, dbname, port, charset, username e password
 * @return PDO Objeto PDO com a ligação à Base de Dados
 */
function connectDB($db) {
    try {
        $pdo = new PDO(
        'mysql:host=' . $db['host'] . ';' .
        'port=' . $db['port'] . ';' .
        'charset=' . $db[ 'charset'] . ';' .
        'dbname=' . $db['dbname'] . ';' ,
        $db['username'],
        $db['password']
        );
    } catch (PDOException $e){
        die('Erro ao ligar ao servidor' . $e->getMessage());
    }
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

/**
 * Verifica se o modo DEBUG está definido e ativo e opcionalmente acrescenta informação à variável global $_DEBUG
 * @return boolean
 */
function debug($info = '') {
    if(defined('DEBUG') && DEBUG){
        global $_DEBUG;
        $_DEBUG .= $info;
        return true;
    }
    return false;
}
