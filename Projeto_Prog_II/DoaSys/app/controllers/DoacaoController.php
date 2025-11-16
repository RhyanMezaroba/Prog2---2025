<?php
// app/controllers/DoacaoController.php
require_once __DIR__ . '/../models/Doacao.php';
require_once __DIR__ . '/../models/Usuario.php';

class DoacaoController {

    public function listar() {
        // coleta filtros GET
        $filtros = [
            'categoria' => $_GET['categoria'] ?? null,
            'status' => $_GET['status'] ?? null,
            'data_inicio' => $_GET['data_inicio'] ?? null,
            'data_fim' => $_GET['data_fim'] ?? null
        ];

        $doacoes = Doacao::listarTodos($filtros);

        // a sua view é .html — se preferir .php, renomeie o arquivo
        include __DIR__ . '/../views/doacoes/doacoes.html';
    }

    public function cadastrar() {
        include __DIR__ . '/../views/doacoes/cadastro.html';
    }

    public function salvar() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /doacoes');
            exit;
        }

        // Sanitização básica
        $sanitize = function($key) {
            return isset($_POST[$key]) ? trim($_POST[$key]) : null;
        };

        $nome_doador       = $sanitize('nome_doador');
        $documento         = $sanitize('documento');
        $email             = $sanitize('email');
        $telefone          = $sanitize('telefone');

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
        $estado            = $sanitize('estado');

        // criar um título breve para a doação (pode mudar conforme preferir)
        $titulo = $categoria ? ($categoria . ' - ' . mb_substr($descricao ?? '', 0, 40)) : (mb_substr($descricao ?? '', 0, 40));

        // usuario_id se estiver logado
        $usuario_id = $_SESSION['usuario_id'] ?? null;

        // Monta o array esperado pelo model Doacao::criar()
        // O model aceita um array associativo com chaves correspondentes aos nomes dos parâmetros (sem os dois pontos)
        $params = [
            'usuario_id'   => $usuario_id,
            'titulo'       => $titulo ?: 'Doação',
            'descricao'    => $descricao,
            'categoria'    => $categoria,
            'quantidade'   => $quantidade ?: null,
            'valor'        => $valor ?: null,
            'cidade'       => $cidade,
            'bairro'       => $bairro,
            'endereco'     => $endereco,
            'cep'          => $cep,
            'status'       => 'pendente',
            'data_doacao'  => $data_doacao ?: null
        ];

        // Tenta salvar
        try {
            $ok = Doacao::criar($params);
            if ($ok) {
                // flash simples na sessão (se usar nas views)
                $_SESSION['flash_success'] = 'Doação cadastrada com sucesso.';
            } else {
                $_SESSION['flash_error'] = 'Erro ao cadastrar a doação.';
            }
        } catch (Exception $e) {
            // logar o erro em produção/arquivo; aqui mostramos mensagem simples
            $_SESSION['flash_error'] = 'Erro no servidor: ' . $e->getMessage();
        }

        // Redireciona para a lista de doações (rota limpa)
        header('Location: /doacoes');
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
            'titulo' => $_POST['titulo'] ?? null,
            'descricao' => $_POST['descricao'] ?? null,
            'categoria' => $_POST['categoria'] ?? null,
            'quantidade' => $_POST['quantidade'] ?: null,
            'valor' => $_POST['valor'] ?: null,
            'cidade' => $_POST['cidade'] ?? null,
            'bairro' => $_POST['bairro'] ?? null,
            'endereco' => $_POST['endereco'] ?? null,
            'cep' => $_POST['cep'] ?? null,
            'status' => $_POST['status'] ?? null,
            'data_doacao' => $_POST['data_doacao'] ?: null
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
