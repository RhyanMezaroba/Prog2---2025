<?php
// teste rápido de conexão
$conn = require __DIR__ . '/app/config/database.php';
if ($conn instanceof mysqli) {
    $res = $conn->query('SELECT 1 as ok');
    var_dump($res->fetch_assoc());
    exit;
}
echo "Conexão não retornou mysqli";