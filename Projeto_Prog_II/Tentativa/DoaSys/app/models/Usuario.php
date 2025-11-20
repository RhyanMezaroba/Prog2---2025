<?php
// app/models/Usuario.php
require_once __DIR__ . '/Conexao.php';

class Usuario {
    public static function criar($nome, $email, $senhaHash, $tipo = 'cliente', $documento = null) {
        $db = Conexao::getInstance();
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, documento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$nome, $email, $senhaHash, $tipo, $documento]);
    }

    public static function buscarPorEmail($email) {
        $db = Conexao::getInstance();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function buscarPorId($id) {
        $db = Conexao::getInstance();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function listarTodos() {
        $db = Conexao::getInstance();
        $stmt = $db->query("SELECT id, nome, email, tipo, documento, criado_em FROM usuarios ORDER BY criado_em DESC");
        return $stmt->fetchAll();
    }

    public static function atualizar($id, $dados) {
        $db = Conexao::getInstance();
        $fields = [];
        $values = [];
        foreach ($dados as $k => $v) {
            $fields[] = "$k = ?";
            $values[] = $v;
        }
        $values[] = $id;
        $sql = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute($values);
    }
}
