<?php
// app/models/Doacao.php
require_once __DIR__ . '/Conexao.php';

class Doacao {
    public static function criar($dados) {
        $db = Conexao::getInstance();
        $sql = "INSERT INTO doacoes (usuario_id, titulo, descricao, categoria, quantidade, valor, cidade, bairro, endereco, cep, status, data_doacao)
                VALUES (:usuario_id, :titulo, :descricao, :categoria, :quantidade, :valor, :cidade, :bairro, :endereco, :cep, :status, :data_doacao)";
        $stmt = $db->prepare($sql);
        return $stmt->execute($dados);
    }

    public static function listarTodos($filtros = []) {
        $db = Conexao::getInstance();
        $sql = "SELECT d.*, u.nome AS doador_nome FROM doacoes d LEFT JOIN usuarios u ON d.usuario_id = u.id";
        $wheres = [];
        $params = [];
        if (!empty($filtros['categoria'])) {
            $wheres[] = "d.categoria = :categoria"; $params[':categoria'] = $filtros['categoria'];
        }
        if (!empty($filtros['status'])) {
            $wheres[] = "d.status = :status"; $params[':status'] = $filtros['status'];
        }
        if (!empty($filtros['data_inicio'])) {
            $wheres[] = "d.data_doacao >= :di"; $params[':di'] = $filtros['data_inicio'];
        }
        if (!empty($filtros['data_fim'])) {
            $wheres[] = "d.data_doacao <= :df"; $params[':df'] = $filtros['data_fim'];
        }
        if ($wheres) $sql .= " WHERE " . implode(' AND ', $wheres);
        $sql .= " ORDER BY d.criado_em DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function buscarPorId($id) {
        $db = Conexao::getInstance();
        $stmt = $db->prepare("SELECT * FROM doacoes WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
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
        $sql = "UPDATE doacoes SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute($values);
    }

    public static function excluir($id) {
        $db = Conexao::getInstance();
        $stmt = $db->prepare("DELETE FROM doacoes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
