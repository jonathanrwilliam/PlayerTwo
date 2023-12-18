<?php

/* * * * * * * * * * * * * * *
 * C O N F I G U R A Ç Ã O
 * 
 */
// Autor
define('AUTHOR', 'Jonathan');
define('ANO_LETIVO', '2023');



/* * * * * * * * * * * * * * *
 * B A S E   D E   D A D O S
 */
# ALTERAR GRUPO
$guru = '08';
$dsg_dbo = [
    'host' => 'mysql-sa.mgmt.ua.pt',
    'port' => '3306',
    'charset' => 'utf8',
    'dbname' => 'esan-dsg' . $guru,
    'username' => 'esan-dsg' . $guru . '-dbo',
    # COLOCAR PASSWORD DBO
    'password' => 'KAkyPKRtAdl40I8U'
];
$dsg_web = [
    'host' => 'mysql-sa.mgmt.ua.pt',
    'port' => '3306',
    'charset' => 'utf8',
    'dbname' => 'esan-dsg' . $guru,
    'username' => 'esan-dsg' . $guru . '-web',
    # COLOCAR PASSWORD WEB
    'password' => 'bq2VN1aZjjA35zAp'
];

/** @var Array $db['host','port','charset','dbname','username','password'] */
# Descomentar utilizador DBO ou WEB
$db = $dsg_dbo;
#$db = $dsg_web;



/* * * * * * * * * *
 * D E B U G
 */
define('DEBUG', true);

if (defined('DEBUG') && DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $_DEBUG = '';
}

//Configuracoes ficheiros upload

define('WEB_SERVER','https://esan-tesp-ds-paw.web.ua.pt');
define('WEB_ROOT','/tesp-ds-g8/');

define('SERVER_FILE_ROOT','//ARCA.STORAGE.UA.PT/HOSTING/esan-tesp-ds-paw.web.ua.pt'.WEB_ROOT);
define('UPLOAD_FOLDER','uploads/');
define('UPLOAD_FOTOS','fotos/');
define('UPLOAD_POSTS','posts/');

define('UPLOAD_PATH',SERVER_FILE_ROOT . UPLOAD_FOLDER);
