<?php
require_once __DIR__ . '/Model.php';

class donationModel extends Model {

    public function create($data) {
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

    public function getAll() {
        return self::$db
            ->query("SELECT d.*, u.nome AS nome_usuario, u.tipo AS tipo_usuario
                     FROM doacoes d
                     LEFT JOIN usuarios u ON d.usuario_id = u.id
                     ORDER BY d.criado_em DESC")
            ->fetchAll();
    }

    /**
     * Retorna doações filtradas por tipo e intervalo de data (data_doacao).
     * Parâmetros opcionais: $tipo (string), $dataInicio (YYYY-MM-DD), $dataFim (YYYY-MM-DD)
     */
    public function getFiltered(?string $tipo = null, ?string $dataInicio = null, ?string $dataFim = null)
    {
        $sql = "SELECT d.*, u.nome AS nome_usuario, u.tipo AS tipo_usuario
                FROM doacoes d
                LEFT JOIN usuarios u ON d.usuario_id = u.id";
        $conds = [];
        $params = [];

        if ($tipo) {
            $conds[] = "d.categoria = :tipo OR d.titulo LIKE :tipo_like";
            $params[':tipo'] = $tipo;
            $params[':tipo_like'] = "%{$tipo}%";
        }

        // usa campo data_doacao se existir
        if ($dataInicio) {
            $conds[] = "d.data_doacao >= :dataInicio";
            $params[':dataInicio'] = $dataInicio;
        }
        if ($dataFim) {
            $conds[] = "d.data_doacao <= :dataFim";
            $params[':dataFim'] = $dataFim;
        }

        if (!empty($conds)) {
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        }

        $sql .= ' ORDER BY d.criado_em DESC';

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
