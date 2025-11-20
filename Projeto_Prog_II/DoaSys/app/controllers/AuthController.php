<?php

require_once __DIR__ . '/../Models/User.php';

class authController
{
    protected $userModel;
    protected $viewsPath;

    public function __construct()
    {
        $this->userModel = new User();
        $this->viewsPath = __DIR__ . '/../../resources/views/auth/';
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function render(string $viewFile, array $data = [])
    {
        extract($data, EXTR_SKIP);
        $file = $this->viewsPath . $viewFile . '.php';
        if (!file_exists($file)) {
            throw new \RuntimeException("View not found: {$file}");
        }
        require $file;
    }

    protected function redirect(string $url = null)
    {
        $url = $url ?? ($_SERVER['HTTP_REFERER'] ?? '/');
        header('Location: ' . $url);
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

    // Mostra formulário de login
    public function showLogin()
    {
        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['old'], $_SESSION['errors']);
        $this->render('login', compact('old', 'errors'));
    }

    // Processa login (POST)
    public function login()
    {
        $data = $this->sanitizeInput($_POST);
        $errors = $this->validateLogin($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect();
        }

        $user = $this->userModel->findByEmail($data['email'] ?? '');
        if (!$user || !password_verify($data['password'] ?? '', $user['senha'] ?? '')) {
            $this->setFlash('error', 'Credenciais inválidas.');
            $this->redirect();
        }

        // Autentica
        $_SESSION['user_id'] = $user['id'];
        $this->setFlash('success', 'Login realizado.');
        $this->redirect('/'); // ajustar rota após login
    }

    // Mostra formulário de registro
    public function showRegister()
    {
        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['old'], $_SESSION['errors']);
        $this->render('register', compact('old', 'errors'));
    }

    // Processa registro (POST)
    public function register()
    {
        $data = $this->sanitizeInput($_POST);
        $errors = $this->validateRegister($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect();
        }

        // evita duplicar email
        if ($this->userModel->findByEmail($data['email'])) {
            $this->setFlash('error', 'E-mail já cadastrado.');
            $this->redirect();
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $payload = [
            'nome' => $data['nome'] ?? null,
            'email' => $data['email'],
            'senha' => $passwordHash,
            'tipo' => $data['tipo'] ?? 'usuario'
        ];

        try {
            $newId = $this->userModel->create($payload);
            $_SESSION['user_id'] = $newId;
            $this->setFlash('success', 'Conta criada.');
            $this->redirect('/');
        } catch (\Exception $e) {
            $this->setFlash('error', 'Erro ao criar conta: ' . $e->getMessage());
            $this->redirect();
        }
    }

    // Logout
    public function logout()
    {
        unset($_SESSION['user_id']);
        session_regenerate_id(true);
        $this->setFlash('success', 'Desconectado.');
        $this->redirect('/');
    }

    // Retorna usuário atual ou null
    public function currentUser()
    {
        if (!empty($_SESSION['user_id'])) {
            return $this->userModel->findById($_SESSION['user_id']);
        }
        return null;
    }

    // Protege rotas: redireciona para login se não autenticado
    public function requireAuth()
    {
        if (!$this->currentUser()) {
            $this->setFlash('error', 'Acesso restrito. Faça login.');
            $this->redirect('/auth/login');
        }
    }

    // Helpers
    protected function sanitizeInput(array $input)
    {
        $clean = [];
        foreach ($input as $k => $v) {
            $clean[$k] = is_string($v) ? trim($v) : $v;
        }
        return $clean;
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
            $errors['password'] = 'Senha com mínimo de 6 caracteres.';
        }
        if (($data['password'] ?? '') !== ($data['password_confirm'] ?? '')) {
            $errors['password_confirm'] = 'Confirmação de senha não confere.';
        }
        return $errors;
    }
}
?>