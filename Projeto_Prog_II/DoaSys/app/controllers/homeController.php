<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\UserModel;

class HomeController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        parent::__construct();
        // mantém caminho padrão (resources/views/) — se preferir uma pasta específica:
        // $this->setViewsPath(__DIR__ . '/../../resources/views/home/');
        $this->userModel = new UserModel();
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
            $currentUser = $this->userModel->find($_SESSION['user_id']);
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