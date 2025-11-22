<?php
// DB connection using mysqli — returns the connection object
$host    = "127.0.0.1";
$port    = 3306;
$dbname  = "DoaSys_BD";
$user    = "root";
$pass    = "1234";
$charset = "utf8mb4";

// Conexão mysqli - ordem correta: host, user, pass, dbname, port
$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    error_log('DB connect error: ' . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// define charset corretamente
if (! $conn->set_charset($charset)) {
    error_log('Erro ao definir charset: ' . $conn->error);
}

// NÃO fechar a conexão aqui se o resto da app precisa dela
// use: $conn = require __DIR__ . '/db.php';

return $conn;
?>
