<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    public function mostrarFormularioRegistro() {
        include __DIR__ . '/../views/auth/registro.php'; // caso tenha view
    }

    public function registrar() {
        session_start();
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $tipo = $_POST['tipo'] ?? 'cliente'; // 'cliente' ou 'instituicao'
        $documento = $_POST['documento'] ?? null;

        if (!$nome || !$senha) {
            $_SESSION['flash_error'] = "Nome e senha são obrigatórios.";
            header('Location: /usuario/cadastrar');
            exit;
        }

        // evitar duplicate email
        if ($email && Usuario::buscarPorEmail($email)) {
            $_SESSION['flash_error'] = "E-mail já cadastrado.";
            header('Location: /usuario/cadastrar');
            exit;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        Usuario::criar($nome, $email ?: null, $senhaHash, $tipo, $documento);

        $_SESSION['flash_success'] = "Cadastro realizado com sucesso. Faça login.";
        header('Location: /login');
    }

    public function mostrarFormularioLogin() {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        session_start();
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $usuario = Usuario::buscarPorEmail($email);
        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $_SESSION['flash_error'] = 'Credenciais inválidas.';
            header('Location: /login');
            exit;
        }

        // set session
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];

        header('Location: /'); // home
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }
}
