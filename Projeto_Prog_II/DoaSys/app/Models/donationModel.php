<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class DonationModel extends Model
{
    public function create($data)
    {
        $sql = "INSERT INTO doacoes 
        (usuario_id, beneficiario_nome, beneficiario_cpf, titulo, descricao, categoria,
         quantidade, valor, cidade, bairro, endereco, cep, status, data_doacao)
        VALUES 
        (:usuario_id, :beneficiario_nome, :beneficiario_cpf, :titulo, :descricao, :categoria,
         :quantidade, :valor, :cidade, :bairro, :endereco, :cep, :status, :data_doacao)";

        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':usuario_id'        => $data['usuario_id'] ?? null,
            ':beneficiario_nome' => $data['beneficiario_nome'] ?? null,
            ':beneficiario_cpf'  => $data['beneficiario_cpf'] ?? null,
            ':titulo'            => $data['titulo'],
            ':descricao'         => $data['descricao'] ?? null,
            ':categoria'         => $data['categoria'] ?? null,
            ':quantidade'        => $data['quantidade'] ?? null,
            ':valor'             => $data['valor'] ?? null,
            ':cidade'            => $data['cidade'] ?? null,
            ':bairro'            => $data['bairro'] ?? null,
            ':endereco'          => $data['endereco'] ?? null,
            ':cep'               => $data['cep'] ?? null,
            ':status'            => $data['status'] ?? 'pendente',
            ':data_doacao'       => $data['data_doacao'] ?? null
        ]);

        return self::$db->lastInsertId();
    }

    public function getAll()
    {
        return self::$db
            ->query("SELECT d.*, u.nome AS nome_usuario, u.tipo AS tipo_usuario
                     FROM doacoes d
                     LEFT JOIN usuarios u ON d.usuario_id = u.id
                     ORDER BY d.criado_em DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFiltered(?string $tipo = null, ?string $dataInicio = null, ?string $dataFim = null)
    {
        $sql = "SELECT d.*, u.nome AS nome_usuario, u.tipo AS tipo_usuario
                FROM doacoes d
                LEFT JOIN usuarios u ON d.usuario_id = u.id";

        $conds = [];
        $params = [];

        if ($tipo) {
            $conds[] = "(d.categoria = :tipo OR d.titulo LIKE :tipo_like)";
            $params[':tipo'] = $tipo;
            $params[':tipo_like'] = "%{$tipo}%";
        }

        if ($dataInicio) {
            $conds[] = "d.data_doacao >= :dataInicio";
            $params[':dataInicio'] = $dataInicio;
        }

        if ($dataFim) {
            $conds[] = "d.data_doacao <= :dataFim";
            $params[':dataFim'] = $dataFim;
        }

        if (!empty($conds)) {
            $sql .= " WHERE " . implode(" AND ", $conds);
        }

        $sql .= " ORDER BY d.criado_em DESC";

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = self::$db->prepare("
            SELECT d.*, u.nome AS nome_usuario, u.tipo AS tipo_usuario
            FROM doacoes d
            LEFT JOIN usuarios u ON d.usuario_id = u.id
            WHERE d.id = :id LIMIT 1
        ");

        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, array $data)
    {
        $sql = "UPDATE doacoes SET
            usuario_id        = :usuario_id,
            beneficiario_nome = :beneficiario_nome,
            beneficiario_cpf  = :beneficiario_cpf,
            titulo            = :titulo,
            descricao         = :descricao,
            categoria         = :categoria,
            quantidade        = :quantidade,
            valor             = :valor,
            cidade            = :cidade,
            bairro            = :bairro,
            endereco          = :endereco,
            cep               = :cep,
            status            = :status,
            data_doacao       = :data_doacao
        WHERE id = :id";

        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':usuario_id'        => $data['usuario_id'] ?? null,
            ':beneficiario_nome' => $data['beneficiario_nome'] ?? null,
            ':beneficiario_cpf'  => $data['beneficiario_cpf'] ?? null,
            ':titulo'            => $data['titulo'] ?? null,
            ':descricao'         => $data['descricao'] ?? null,
            ':categoria'         => $data['categoria'] ?? null,
            ':quantidade'        => $data['quantidade'] ?? null,
            ':valor'             => $data['valor'] ?? null,
            ':cidade'            => $data['cidade'] ?? null,
            ':bairro'            => $data['bairro'] ?? null,
            ':endereco'          => $data['endereco'] ?? null,
            ':cep'               => $data['cep'] ?? null,
            ':status'            => $data['status'] ?? 'pendente',
            ':data_doacao'       => $data['data_doacao'] ?? null,
            ':id'                => $id
        ]);

        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $stmt = self::$db->prepare("DELETE FROM doacoes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    public function getPaged(int $page = 1, int $perPage = 10, ?string $tipo = null, ?string $dataInicio = null, ?string $dataFim = null)
    {
        $offset = max(0, ($page - 1) * $perPage);

        $baseSql = "FROM doacoes d
                    LEFT JOIN usuarios u ON d.usuario_id = u.id";

        $conds = [];
        $params = [];

        if ($tipo) {
            $conds[] = "(d.categoria = :tipo OR d.titulo LIKE :tipo_like)";
            $params[':tipo'] = $tipo;
            $params[':tipo_like'] = "%{$tipo}%";
        }

        if ($dataInicio) {
            $conds[] = "d.data_doacao >= :dataInicio";
            $params[':dataInicio'] = $dataInicio;
        }

        if ($dataFim) {
            $conds[] = "d.data_doacao <= :dataFim";
            $params[':dataFim'] = $dataFim;
        }

        $where = empty($conds) ? '' : ' WHERE ' . implode(' AND ', $conds);

        // total
        $countSql = "SELECT COUNT(*) " . $baseSql . $where;
        $countStmt = self::$db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        // data
        $dataSql = "SELECT d.*, u.nome AS nome_usuario, u.tipo AS tipo_usuario 
                    " . $baseSql . $where .
                    " ORDER BY d.criado_em DESC LIMIT :limit OFFSET :offset";

        $stmt = self::$db->prepare($dataSql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return [
            'data'  => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total
        ];
    }
}