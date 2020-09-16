<?php
require_once(dirname(__DIR__ , 1) . '\config.php');

$dsn = "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB;
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     global $pdo;
     $pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASS, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}