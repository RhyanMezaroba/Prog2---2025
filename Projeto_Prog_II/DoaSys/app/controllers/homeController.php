<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/User.php';

class homeController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        parent::__construct();
        // mantém caminho padrão (resources/views/) — se preferir uma pasta específica:
        // $this->setViewsPath(__DIR__ . '/../../resources/views/home/');
        $this->userModel = new User();
    }

    // Página inicial
    public function index()
    {
        $success = $this->getFlash('success');
        $error   = $this->getFlash('error');
        $old     = $this->getOld();
        $errors  = $this->getErrors();

        $currentUser = null;
        if (!empty($_SESSION['user_id'])) {
            $currentUser = $this->userModel->findById($_SESSION['user_id']);
        }

        // renderiza resources/views/home/index.php
        $this->render('home/index', compact('success', 'error', 'old', 'errors', 'currentUser'));
    }

    // Exemplo: rota estática "sobre"
    public function about()
    {
        $this->render('home/about');
    }
}
?>