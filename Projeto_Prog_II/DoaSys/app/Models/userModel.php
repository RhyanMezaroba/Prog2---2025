<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class UserModel extends Model
{
    public function create(array $data)
    {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, documento)
                VALUES (:nome, :email, :senha, :tipo, :documento)";

        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':nome'      => $data['nome'],
            ':email'     => $data['email'],
            ':senha'     => $data['senha'], // já deve vir com password_hash
            ':tipo'      => $data['tipo'] ?? 'usuario',
            ':documento' => $data['documento'] ?? null
        ]);

        return self::$db->lastInsertId();
    }

    public function findByEmail(string $email)
    {
        $stmt = self::$db->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find(int $id)
    {
        $stmt = self::$db->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}