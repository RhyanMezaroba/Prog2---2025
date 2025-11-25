<?php

namespace App\Controllers;

use App\Models\UserModel;
use RuntimeException;

class AuthController
{
    protected $UserModel;
    protected $viewsPath;
    protected $baseRouter = '/DoaSys/App/migration/router.php';

    public function __construct()
    {
        $this->UserModel = new UserModel();

        // Caminho real para: App/Views/
        $this->viewsPath = realpath(__DIR__ . '/../Views') . DIRECTORY_SEPARATOR;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // --------------------------
    // Renderização de views
    // --------------------------
    protected function render(string $viewFile, array $data = [])
    {
        extract($data, EXTR_SKIP);

        $file = $this->viewsPath . $viewFile . '.php';

        if (!file_exists($file)) {
            throw new RuntimeException("View not found: {$file}");
        }

        require $file;
    }

    // --------------------------
    // Montar URL do router
    // --------------------------
    protected function route(string $controller, string $action, array $query = [])
    {
        $qs = http_build_query(array_merge([
            'c' => $controller,
            'a' => $action
        ], $query));

        return $this->baseRouter . '?' . $qs;
    }

    protected function redirect(string $url = null)
    {
        if ($url === null) {
            $url = $_SERVER['HTTP_REFERER'] ?? $this->baseRouter;
        }
        header("Location: {$url}");
        exit;
    }

    protected function setFlash(string $key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    protected function getFlash(string $key)
    {
        $v = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $v;
    }

    // ==================================================
    //                    LOGIN
    // ==================================================

    public function showLogin()
    {
        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
        $flash = $_SESSION['flash'] ?? [];

        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);

        $this->render('Auth/loginAuth', compact('old', 'errors', 'flash'));
    }

    public function login()
    {
        $data = $this->sanitizeInput($_POST);
        $errors = $this->validateLogin($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect($this->route('auth', 'showLogin'));
        }

        $user = $this->UserModel->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['senha'])) {
            $this->setFlash('error', 'Credenciais inválidas.');
            $_SESSION['old'] = ['email' => $data['email']];
            $this->redirect($this->route('auth', 'showLogin'));
        }

        $_SESSION['user_id'] = $user['id'];
        $this->setFlash('success', 'Login realizado com sucesso.');

        $this->redirect($this->route('home', 'index'));
    }

    // ==================================================
    //                    REGISTER
    // ==================================================

    public function showRegister()
    {
        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
        $flash = $_SESSION['flash'] ?? [];

        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);

        $this->render('Auth/register', compact('old', 'errors', 'flash'));
    }

    public function register()
    {
        $data = $this->sanitizeInput($_POST);
        $errors = $this->validateRegister($data);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect($this->route('auth', 'showRegister'));
        }

        if ($this->UserModel->findByEmail($data['email'])) {
            $this->setFlash('error', 'E-mail já cadastrado.');
            $this->redirect($this->route('auth', 'showRegister'));
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        try {
            $userId = $this->UserModel->create([
                'nome' => $data['nome'],
                'email' => $data['email'],
                'senha' => $passwordHash,
                'tipo' => $data['tipo'] ?? 'usuario'
            ]);

            $_SESSION['user_id'] = $userId;
            $this->setFlash('success', 'Conta criada com sucesso.');

            $this->redirect($this->route('home', 'index'));

        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao criar conta: ' . $e->getMessage());
            $this->redirect($this->route('auth', 'showRegister'));
        }
    }

    // ==================================================
    //                    LOGOUT
    // ==================================================
    public function logout()
    {
        unset($_SESSION['user_id']);
        session_regenerate_id(true);

        $this->setFlash('success', 'Você saiu da sua conta.');

        $this->redirect($this->route('home', 'index'));
    }

    // ==================================================
    //             AUXILIARES DE AUTH
    // ==================================================

    public function currentUser()
    {
        if (!empty($_SESSION['user_id'])) {
            return $this->UserModel->find($_SESSION['user_id']);
        }
        return null;
    }

    public function requireAuth()
    {
        if (!$this->currentUser()) {
            $this->setFlash('error', 'Acesso restrito. Faça login.');
            $this->redirect($this->route('auth', 'showLogin'));
        }
    }

    public function requireAdmin()
    {
        $user = $this->currentUser();

        if (!$user) {
            $this->setFlash('error', 'Acesso restrito. Faça login.');
            $this->redirect($this->route('auth', 'showLogin'));
        }

        if (strtolower($user['tipo']) !== 'admin') {
            $this->setFlash('error', 'Acesso negado. Requer administrador.');
            $this->redirect($this->route('home', 'index'));
        }
    }

    // ==================================================
    //                VALIDAÇÃO
    // ==================================================

    protected function sanitizeInput(array $input)
    {
        foreach ($input as $k => $v) {
            $input[$k] = is_string($v) ? trim($v) : $v;
        }
        return $input;
    }

    protected function validateLogin(array $data)
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'E-mail é obrigatório.';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Senha é obrigatória.';
        }

        return $errors;
    }

    protected function validateRegister(array $data)
    {
        $errors = [];

        if (empty($data['nome'])) {
            $errors['nome'] = 'Nome é obrigatório.';
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail inválido.';
        }
        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors['password'] = 'Senha deve ter no mínimo 6 caracteres.';
        }
        if ($data['password'] !== ($data['password_confirm'] ?? null)) {
            $errors['password_confirm'] = 'As senhas não conferem.';
        }

        return $errors;
    }
}