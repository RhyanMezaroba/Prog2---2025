<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Controllers\AuthController;
use App\Models\DonationModel;

class DonationController extends BaseController
{
    protected $model;
    protected $auth;
    protected $router = '/DoaSys/App/migration/router.php';

    public function __construct()
    {
        parent::__construct();

        $this->model = new DonationModel();
        $this->auth  = new AuthController();

        // Caminho correto das Views
        $this->setViewsPath(__DIR__ . '/../Views/donations/');
    }

    /**
     * LISTAGEM — exige admin
     */
    public function index()
    {
        $this->auth->requireAdmin();

        // Extrai parâmetros de filtro e paginação da URL
        $tipo       = $_GET['tipo'] ?? null;
        $dataInicio = $_GET['dat-inicio'] ?? null;
        $dataFim    = $_GET['data_fim'] ?? null;
        $page       = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage    = 10; // Itens por página

        // Obtém os dados paginados e filtrados
        $pagedData = $this->model->getPaged($page, $perPage, $tipo, $dataInicio, $dataFim);

        $donations  = $pagedData['data'];
        $total      = $pagedData['total'];
        $totalPages = (int)ceil($total / $perPage);

        $success = $this->getFlash('success');
        $error   = $this->getFlash('error');

        $this->render('list', compact(
            'donations',
            'success',
            'error',
            'tipo',
            'dataInicio',
            'dataFim',
            'page',
            'totalPages'
        ));
    }

    /**
     * FORMULÁRIO DE CRIAÇÃO — exige admin
     */
    public function create()
    {
        $this->auth->requireAdmin();

        $old    = $_SESSION['old']    ?? [];
        $errors = $_SESSION['errors'] ?? [];

        unset($_SESSION['old'], $_SESSION['errors']);

        $this->render('create', compact('old', 'errors'));
    }

    /**
     * SALVAR NOVA DOAÇÃO
     */
    public function store()
    {
        $this->auth->requireAdmin();

        $data   = $this->sanitizeInput($_POST);
        $errors = $this->validate($data);

        if ($errors) {
            $this->setErrors($errors);
            $this->setOld($data);
            $this->redirect($this->router . '?c=donation&a=create');
        }

        try {
            $id = $this->model->create($data);

            $this->setFlash('success', "Doação criada com sucesso (ID: {$id}).");
            $this->redirect($this->router . '?c=donation&a=index');

        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro: ' . $e->getMessage());
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

        $old    = $_SESSION['old']    ?? (array)$donation;
        $errors = $_SESSION['errors'] ?? [];

        unset($_SESSION['old'], $_SESSION['errors']);

        $this->render('edit', compact('donation', 'old', 'errors'));
    }

    /**
     * ATUALIZAR DOAÇÃO
     */
    public function update($id)
    {
        $data   = $this->sanitizeInput($_POST);
        $errors = $this->validate($data);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = $data;

            $this->redirect($this->router . "?c=donation&a=edit&id={$id}");
        }

        try {
            $this->model->update($id, $data);

            $this->setFlash('success', 'Doação atualizada com sucesso.');
            $this->redirect($this->router . '?c=donation&a=index');

        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro: ' . $e->getMessage());
            $this->redirect($this->router . "?c=donation&a=edit&id={$id}");
        }
    }

    /**
     * DELETAR
     */
    public function delete($id)
    {
        try {
            $this->model->delete($id);

            $this->setFlash('success', 'Doação removida.');
            $this->redirect($this->router . '?c=donation&a=index');

        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro: ' . $e->getMessage());
            $this->redirect($this->router . '?c=donation&a=index');
        }
    }

    // Helpers
    protected function sanitizeInput(array $input): array
    {
        foreach ($input as $k => $v) {
            $input[$k] = is_string($v) ? trim($v) : $v;
        }
        return $input;
    }

    protected function validate(array $data)
    {
        $errors = [];

        if (empty($data['titulo'])) {
            $errors['titulo'] = 'O título é obrigatório.';
        }

        if ($data['quantidade'] !== '' && !is_numeric($data['quantidade'])) {
            $errors['quantidade'] = 'Quantidade inválida.';
        }

        if ($data['valor'] !== '' && !is_numeric(str_replace(',', '.', $data['valor']))) {
            $errors['valor'] = 'Valor inválido.';
        }

        return $errors;
    }
}