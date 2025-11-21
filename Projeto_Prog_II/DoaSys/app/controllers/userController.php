<?php
require_once __DIR__ . '/baseController.php';
require_once __DIR__ . '/../Models/userModel.php';

class UserController extends baseController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        parent::__construct();
        // conecta com PDO local (mesma configuração usada nos models)
        $host   = 'localhost';
        $dbname = 'DoaSys_BD';
        $user   = 'root';
        $pass   = '';
        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erro ao conectar ao banco (UserController): ' . $e->getMessage());
        }

        // tenta instanciar model auxiliar (se existir)
        if (class_exists('userModel')) {
            $this->model = new userModel();
        }

        $this->setViewsPath(__DIR__ . '/../../resources/views/users/');
    }

    // Lista usuários
    public function index()
    {
        $stmt = $this->db->query("SELECT id, nome, email, tipo, criado_em FROM usuarios ORDER BY id DESC");
        $users = $stmt->fetchAll();
        $success = $this->getFlash('success');
        $error = $this->getFlash('error');
        $this->render('index', compact('users', 'success', 'error'));
    }

    // Mostra formulário de criação
    public function create()
    {
        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['old'], $_SESSION['errors']);
        $this->render('create', compact('old', 'errors'));
    }

    // Salva novo usuário (POST)
    public function store()
    {
        $data = $this->sanitizeInput($_POST);
        $errors = [];
        if (empty($data['nome'])) $errors['nome'] = 'Nome é obrigatório.';
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'E-mail inválido.';
        if (empty($data['password']) || strlen($data['password']) < 6) $errors['password'] = 'Senha com mínimo de 6 caracteres.';
        if (($data['password'] ?? '') !== ($data['password_confirm'] ?? '')) $errors['password_confirm'] = 'Confirmação não confere.';

        if (!empty($errors)) {
            $this->setErrors($errors);
            $this->setOld($data);
            $this->redirect();
        }

        // evita duplicar email
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $data['email']]);
        if ($stmt->fetch()) {
            $this->setFlash('error', 'E-mail já cadastrado.');
            $this->redirect();
        }

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        try {
            $insert = $this->db->prepare("INSERT INTO usuarios (nome, email, senha, tipo, documento, criado_em) VALUES (:nome, :email, :senha, :tipo, :documento, NOW())");
            $insert->execute([
                ':nome' => $data['nome'],
                ':email' => $data['email'],
                ':senha' => $hash,
                ':tipo' => $data['tipo'] ?? 'usuario',
                ':documento' => $data['documento'] ?? null
            ]);
            $this->setFlash('success', 'Usuário criado.');
            $this->redirect('/');
        } catch (Exception $e) {
            $this->setFlash('error', 'Erro ao criar usuário: ' . $e->getMessage());
            $this->redirect();
        }
    }

    // Mostrar detalhe/edição
    public function edit($id)
    {
        $stmt = $this->db->prepare("SELECT id, nome, email, tipo, documento FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        if (!$user) {
            $this->setFlash('error', 'Usuário não encontrado.');
            $this->redirect();
        }
        $old = $_SESSION['old'] ?? $user;
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['old'], $_SESSION['errors']);
        $this->render('edit', compact('user', 'old', 'errors'));
    }

    public function update($id)
    {
        $data = $this->sanitizeInput($_POST);
        $errors = [];
        if (empty($data['nome'])) $errors['nome'] = 'Nome é obrigatório.';
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'E-mail inválido.';

        if (!empty($errors)) {
            $this->setErrors($errors);
            $this->setOld($data);
            $this->redirect();
        }

        try {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo, documento = :documento WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nome' => $data['nome'],
                ':email' => $data['email'],
                ':tipo' => $data['tipo'] ?? 'usuario',
                ':documento' => $data['documento'] ?? null,
                ':id' => $id
            ]);
            // atualiza senha se fornecida
            if (!empty($data['password'])) {
                $hash = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->db->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id")->execute([':senha' => $hash, ':id' => $id]);
            }
            $this->setFlash('success', 'Usuário atualizado.');
            $this->redirect();
        } catch (Exception $e) {
            $this->setFlash('error', 'Erro ao atualizar: ' . $e->getMessage());
            $this->redirect();
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $this->setFlash('success', 'Usuário removido.');
            $this->redirect();
        } catch (Exception $e) {
            $this->setFlash('error', 'Erro ao remover usuário: ' . $e->getMessage());
            $this->redirect();
        }
    }
}
?>
