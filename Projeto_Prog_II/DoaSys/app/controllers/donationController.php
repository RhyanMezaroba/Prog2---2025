<?php

use App\Controllers\AuthController;
// filepath: c:\laragon\www\DoaSys\App\Controllers\DonationController.php
require_once __DIR__ . '/baseController.php';
require_once __DIR__ . '/../Models/donationModel.php';
require_once __DIR__ . '/authController.php';

class DonationController extends baseController
{
    protected $model;
    protected $viewsPath;
    protected $auth;

    // Caminho correto do router
    protected $router = '/DoaSys/App/migration/router.php';

    public function __construct()
    {
        parent::__construct();
        $this->model = new DonationModel();

        // Ajuste correto para sua estrutura
        $this->setViewsPath(__DIR__ . '/../Views/donations/');

        // controller de autenticação
        $this->auth = new AuthController();
    }

    /**
     * LISTAGEM — exige admin
     */
    public function index()
    {
        $this->auth->requireAdmin();

        $donations = $this->model->getAll();
        $success = $this->getFlash('success');
        $error = $this->getFlash('error');

        $this->render('index', compact('donations', 'success', 'error'));
    }

    /**
     * FORMULÁRIO DE CRIAÇÃO — exige admin
     */
    public function create()
    {
        $this->auth->requireAdmin();

        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];

        unset($_SESSION['old'], $_SESSION['errors']);

        $this->render('create', compact('old', 'errors'));
    }

    /**
     * SALVAR NOVA DOAÇÃO — POST — exige admin
     */
    public function store()
    {
        $this->auth->requireAdmin();

        $data = $this->sanitizeInput($_POST);

        // validações
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->setErrors($errors);
            $this->setOld($data);
            $this->redirect($this->router . '?c=donation&a=create');
        }

        try {
            $insertId = $this->model->create($data);

            $this->setFlash('success', 'Doação criada com sucesso (ID: ' . $insertId . ').');
            $this->redirect($this->router . '?c=donation&a=index');

        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao salvar: ' . $e->getMessage());
            $this->redirect($this->router . '?c=donation&a=create');
        }
    }

    /**
     * FORMULÁRIO DE EDIÇÃO
     */
    public function edit($id)
    {
        $donation = $this->model->findById($id);

        if (!$donation) {
            $this->setFlash('error', 'Doação não encontrada.');
            $this->redirect($this->router . '?c=donation&a=index');
        }

        $old = $_SESSION['old'] ?? (array)$donation;
        $errors = $_SESSION['errors'] ?? [];

        unset($_SESSION['old'], $_SESSION['errors']);

        $this->render('edit', compact('donation', 'old', 'errors'));
    }

    /**
     * ATUALIZAR DOAÇÃO — POST
     */
    public function update($id)
    {
        $data = $this->sanitizeInput($_POST);

        $errors = $this->validate($data, true);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect($this->router . "?c=donation&a=edit&id={$id}");
        }

        try {
            $this->model->update($id, $data);

            $this->setFlash('success', 'Doação atualizada com sucesso.');
            $this->redirect($this->router . '?c=donation&a=index');

        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao atualizar: ' . $e->getMessage());
            $this->redirect($this->router . "?c=donation&a=edit&id={$id}");
        }
    }

    /**
     * DELETAR DOAÇÃO
     */
    public function delete($id)
    {
        try {
            $this->model->delete($id);

            $this->setFlash('success', 'Doação removida.');
            $this->redirect($this->router . '?c=donation&a=index');

        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao remover: ' . $e->getMessage());
            $this->redirect($this->router . '?c=donation&a=index');
        }
    }

    // --- Helpers ---
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

        if (empty($data['titulo'])) {
            $errors['titulo'] = 'O campo título é obrigatório.';
        }

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