<?php
// filepath: c:\laragon\www\DoaSys\App\Controllers\DonationController.php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/Donation.php';

class DonationController extends BaseController
{
    protected $model;
    protected $viewsPath;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Donation();
        $this->setViewsPath(__DIR__ . '/../../resources/views/donations/');
    }

    // Listar doações
    public function index()
    {
        $donations = $this->model->getAll();
        $success = $this->getFlash('success');
        $error = $this->getFlash('error');
        $this->render('index', compact('donations', 'success', 'error'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['old'], $_SESSION['errors']);
        $this->render('create', compact('old', 'errors'));
    }

    // Salvar nova doação (espera POST)
    public function store()
    {
        $data = $this->sanitizeInput($_POST);

        // validações mínimas (adapte conforme necessário)
        $errors = $this->validate($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect(); // volta ao formulário
        }

        try {
            $insertId = $this->model->create($data);
            $this->setFlash('success', 'Doação criada com sucesso (id: ' . $insertId . ').');
            $this->redirect(); // ajustável para rota de listagem
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao salvar: ' . $e->getMessage());
            $this->redirect();
        }
    }

    // Mostrar formulário de edição
    public function edit($id)
    {
        $donation = $this->model->findById($id) ?? null;
        if (!$donation) {
            $this->setFlash('error', 'Doação não encontrada.');
            $this->redirect();
        }
        $old = $_SESSION['old'] ?? (array)$donation;
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['old'], $_SESSION['errors']);
        $this->render('edit', compact('donation', 'old', 'errors'));
    }

    // Atualizar doação (espera POST)
    public function update($id)
    {
        $data = $this->sanitizeInput($_POST);
        $errors = $this->validate($data, $updating = true);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect();
        }

        try {
            // assume que o model tem método update($id, $data)
            $this->model->update($id, $data);
            $this->setFlash('success', 'Doação atualizada com sucesso.');
            $this->redirect();
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao atualizar: ' . $e->getMessage());
            $this->redirect();
        }
    }

    // Deletar doação
    public function delete($id)
    {
        try {
            // assume que o model tem método delete($id)
            $this->model->delete($id);
            $this->setFlash('success', 'Doação removida.');
            $this->redirect();
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao remover: ' . $e->getMessage());
            $this->redirect();
        }
    }

    // --- Helpers simples ---
    protected function sanitizeInput(array $input): array
    {
        $clean = [];
        foreach ($input as $k => $v) {
            $clean[$k] = is_string($v) ? trim($v) : $v;
        }
        return $clean;
    }

    protected function validate(array $data, bool $updating = false)
    {
        $errors = [];

        // exemplo mínimo: título obrigatório
        if (empty($data['titulo'])) {
            $errors['titulo'] = 'O campo título é obrigatório.';
        }

        // quantidade e valor numéricos quando presentes
        if (isset($data['quantidade']) && $data['quantidade'] !== '' && !is_numeric($data['quantidade'])) {
            $errors['quantidade'] = 'Quantidade precisa ser um número.';
        }
        if (isset($data['valor']) && $data['valor'] !== '' && !is_numeric(str_replace(',', '.', $data['valor']))) {
            $errors['valor'] = 'Valor inválido.';
        }

        return $errors;
    }
}
?>