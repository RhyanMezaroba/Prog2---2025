<?php
// app/models/Doacao.php
require_once __DIR__ . '/Conexao.php';

class Doacao {
    public static function criar(array $params) {
        $conn = require __DIR__ . '/../config/database.php'; // retorna mysqli
        $sql = "INSERT INTO doacoes
            (usuario_id,titulo,descricao,categoria,quantidade,valor,cidade,bairro,endereco,cep,status,data_doacao,beneficiario_nome,beneficiario_cpf)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log('[Doacao::criar] prepare error: ' . $conn->error);
            return false;
        }

        $values = [
            $params['usuario_id'] ?? null,
            $params['titulo'] ?? '',
            $params['descricao'] ?? '',
            $params['categoria'] ?? '',
            $params['quantidade'] ?? null,
            $params['valor'] ?? null,
            $params['cidade'] ?? '',
            $params['bairro'] ?? '',
            $params['endereco'] ?? '',
            $params['cep'] ?? '',
            $params['status'] ?? 'pendente',
            $params['data_doacao'] ?? null,
            $params['beneficiario_nome'] ?? '',
            $params['beneficiario_cpf'] ?? ''
        ];

        // bind tudo como string para evitar erro de tipos; ajuste se quiser tipos exatos
        $types = str_repeat('s', count($values));
        // Ajustar valores nulos para string vazia (mysqli bind não aceita null direto nas versões antigas)
        foreach ($values as &$v) { if (is_null($v)) $v = ''; }
        $bind = array_merge([$types], $values);

        // preparar chamada por referência
        $refs = [];
        foreach ($bind as $k => $v) $refs[$k] = &$bind[$k];

        call_user_func_array([$stmt, 'bind_param'], $refs);

        if (!$stmt->execute()) {
            error_log('[Doacao::criar] execute error: ' . $stmt->error);
            $stmt->close();
            return false;
        }
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        return $ok;
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

    // Exemplo de método criar que usa PDO e retorna true/false
    public static function criarTeste(array $params) {
        // ajuste DSN/usuario/senha conforme seu ambiente (.env ou config)
        $dsn = 'mysql:host=127.0.0.1;port=3306;user= root;pass=1234;dbname=doasys_db;charset=utf8mb4';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            $sql = "INSERT INTO doacoes
                (usuario_id, titulo, descricao, categoria, quantidade, valor, cidade, bairro, endereco, cep, status, data_doacao, beneficiario_nome, beneficiario_cpf)
                VALUES
                (:usuario_id, :titulo, :descricao, :categoria, :quantidade, :valor, :cidade, :bairro, :endereco, :cep, :status, :data_doacao, :beneficiario_nome, :beneficiario_cpf)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $params['usuario_id'],
                ':titulo' => $params['titulo'],
                ':descricao' => $params['descricao'],
                ':categoria' => $params['categoria'],
                ':quantidade' => $params['quantidade'],
                ':valor' => $params['valor'],
                ':cidade' => $params['cidade'],
                ':bairro' => $params['bairro'],
                ':endereco' => $params['endereco'],
                ':cep' => $params['cep'],
                ':status' => $params['status'],
                ':data_doacao' => $params['data_doacao'],
                ':beneficiario_nome' => $params['beneficiario_nome'],
                ':beneficiario_cpf' => $params['beneficiario_cpf'],
            ]);

            return true;
        } catch (PDOException $e) {
            error_log('[Doacao::criar] DB Error: ' . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log('[Doacao::criar] Error: ' . $e->getMessage());
            return false;
        }
    }
}
