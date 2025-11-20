<?php
// app/controllers/DoacaoController.php
require_once __DIR__ . '/../models/Doacao.php';
require_once __DIR__ . '/../models/Usuario.php';

class DoacaoController {

    public function listar() {
        $filtros = [
            'categoria' => $_GET['categoria'] ?? null,
            'status' => $_GET['status'] ?? null,
            'data_inicio' => $_GET['data_inicio'] ?? null,
            'data_fim' => $_GET['data_fim'] ?? null
        ];

        $doacoes = Doacao::listarTodos($filtros);

        include __DIR__ . '/../views/doacoes/doacoes.html';
    }

    public function cadastrar($basePath = '') {
        include __DIR__ . '/../views/doacoes/cadastro.html';
    }

    public function salvar() {
        session_start();

        // DEBUG: registrar método e dados recebidos para investigar por que não persiste
        error_log('[DoacaoController::salvar] METHOD: ' . ($_SERVER['REQUEST_METHOD'] ?? ''));
        error_log('[DoacaoController::salvar] POST: ' . print_r($_POST, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /DoaSys/doacoes');
            exit;
        }

        $sanitize = function($key) {
            return isset($_POST[$key]) ? trim($_POST[$key]) : null;
        };

        $categoria         = $sanitize('categoria');
        $quantidade        = $sanitize('quantidade');
        $descricao         = $sanitize('descricao');
        $valor             = $sanitize('valor');
        $data_doacao       = $sanitize('data_doacao');

        $beneficiario_nome = $sanitize('beneficiario_nome');
        $beneficiario_cpf  = $sanitize('beneficiario_cpf');
        $cep               = $sanitize('cep');
        $endereco          = $sanitize('endereco');
        $bairro            = $sanitize('bairro');
        $cidade            = $sanitize('cidade');

        $titulo = $categoria ? ($categoria . ' - ' . mb_substr($descricao ?? '', 0, 40)) : (mb_substr($descricao ?? '', 0, 40));

        $usuario_id = $_SESSION['usuario_id'] ?? null;

        $params = [
            'usuario_id'        => $usuario_id,
            'titulo'            => $titulo ?: 'Doação',
            'descricao'         => $descricao,
            'categoria'         => $categoria,
            'quantidade'        => $quantidade ?: null,
            'valor'             => $valor ?: null,
            'cidade'            => $cidade,
            'bairro'            => $bairro,
            'endereco'          => $endereco,
            'cep'               => $cep,
            'status'            => 'pendente',
            'data_doacao'       => $data_doacao ?: null,
            'beneficiario_nome' => $beneficiario_nome,
            'beneficiario_cpf'  => $beneficiario_cpf
        ];

        try {
            $ok = Doacao::criar($params);
            error_log('[DoacaoController::salvar] Doacao::criar returned: ' . var_export($ok, true));
            if ($ok) {
                $_SESSION['flash_success'] = 'Doação cadastrada com sucesso.';
            } else {
                $_SESSION['flash_error'] = 'Erro ao cadastrar a doação.';
            }
        } catch (Exception $e) {
            error_log('[DoacaoController::salvar] Exception: ' . $e->getMessage());
            $_SESSION['flash_error'] = 'Erro no servidor: ' . $e->getMessage();
        }

        header('Location: /DoaSys/doacoes');
        exit;
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /doacoes');
            exit;
        }
        $doacao = Doacao::buscarPorId($id);
        include __DIR__ . '/../views/doacoes/editar.php';
    }

    public function atualizar() {
        session_start();
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /doacoes');
            exit;
        }

        $dados = [
            'titulo'            => $_POST['titulo'] ?? null,
            'descricao'         => $_POST['descricao'] ?? null,
            'categoria'         => $_POST['categoria'] ?? null,
            'quantidade'        => $_POST['quantidade'] ?: null,
            'valor'             => $_POST['valor'] ?: null,
            'cidade'            => $_POST['cidade'] ?? null,
            'bairro'            => $_POST['bairro'] ?? null,
            'endereco'          => $_POST['endereco'] ?? null,
            'cep'               => $_POST['cep'] ?? null,
            'status'            => $_POST['status'] ?? null,
            'data_doacao'       => $_POST['data_doacao'] ?: null,
            'beneficiario_nome' => $_POST['beneficiario_nome'] ?? null,
            'beneficiario_cpf'  => $_POST['beneficiario_cpf'] ?? null
        ];

        Doacao::atualizar($id, $dados);
        header('Location: /doacoes');
    }

    public function excluir() {
        session_start();
        $id = $_POST['id'] ?? null;
        if ($id) Doacao::excluir($id);
        header('Location: /doacoes');
    }
}
