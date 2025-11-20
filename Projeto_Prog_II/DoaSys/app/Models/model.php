<?php

namespace App\Core;

use PDO;
use PDOException;

class model
{
    /**
     * Conexão PDO compartilhada entre todas as instâncias/filhas.
     * Protected para permitir access via self::$db nas classes filhas.
     *
     * @var PDO|null
     */
    protected static $db = null;

    public function __construct()
    {
        // Se já existe conexão, nada a fazer
        if (self::$db instanceof PDO) {
            return;
        }

        try {
            // Configurações do banco — ajuste se necessário
            $host   = 'localhost';
            $dbname = 'DoaSys_BD';
            $user   = 'root';
            $pass   = '';

            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
            self::$db = new PDO($dsn, $user, $pass);

            // Configura modos do PDO
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Erro crítico: exiba mensagem curta ou lance exceção (conforme política do seu app)
            die('Erro ao conectar ao banco: ' . $e->getMessage());
        }
    }

    /**
     * Helper opcional para obter a conexão (se preferir usar Model::getDb() em vez de self::$db)
     *
     * @return PDO
     */
    protected static function getDb(): PDO
    {
        if (!(self::$db instanceof PDO)) {
            // força inicialização da conexão
            new static();
        }
        return self::$db;
    }
}
