<?php
require_once __DIR__ . '/model.php';

class userModel extends \App\Core\model {

    public function create($data) {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, documento)
                VALUES (:nome, :email, :senha, :tipo, :documento)";

        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':nome'      => $data['nome'],
            ':email'     => $data['email'],
            ':senha'     => $data['senha'], // password_hash
            ':tipo'      => $data['tipo'] ?? 'anonimo',
            ':documento' => $data['documento'] ?? null
        ]);

        return self::$db->lastInsertId();
    }

    public function findByEmail($email) {
        $stmt = self::$db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email'=>$email]);
        return $stmt->fetch();
    }

    public function find($id) {
        $stmt = self::$db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch();
    }
}
