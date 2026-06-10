<?php
define('DB_HOST', '100.72.104.123');
define('DB_USER', 'solutec_remote');
define('DB_PASS', 'solutec123');
define('DB_NAME', 'solutec_db');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Erro ao conectar ao banco: ' . $e->getMessage());
}
