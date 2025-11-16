<?php

class Conexao {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $cfg = require __DIR__ . '/../config/database.php';
        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset={$cfg['charset']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], $options);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Conexao();
        }
        return self::$instance->pdo;
    }
}
