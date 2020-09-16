<?php
//COMMON APP CONFIG
$APP_NAME = 'easyTemp';
$APP_AUTHOR = 'Muhammad Hanis Irfan';
$APP_VERSION = '0.9';
//BOTH DOESN'T NEED SLASHES IN THE END. HTTPS IS MUST
$APP_URL = 'https://192.168.8.104';
$APP_URL_ALT = 'https://192.168.8.104';
$APP_URL_LOCAL = __DIR__;

//MYSQL DATABASE CONFIG
$MYSQL_HOST = '127.0.0.1';
$MYSQL_DB = 'studenttemp';
$MYSQL_USER = 'root';
$MYSQL_PASS = '';

//DEFINING CONSTANTS. JUST IGNORE THIS BIT
define('APP_NAME', $APP_NAME, true);
define('APP_AUTHOR', $APP_AUTHOR, true);
define('APP_VERSION', $APP_VERSION, true);
define('APP_URL', $APP_URL, true);
define('APP_URL_ALT', $APP_URL_ALT, true);
define('APP_URL_LOCAL', $APP_URL_LOCAL, true);
define('MYSQL_HOST', $MYSQL_HOST, true);
define('MYSQL_DB', $MYSQL_DB, true);
define('MYSQL_USER', $MYSQL_USER, true);
define('MYSQL_PASS', $MYSQL_PASS, true);