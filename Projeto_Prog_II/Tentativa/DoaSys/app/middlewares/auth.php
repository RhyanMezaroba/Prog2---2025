<?php
// app/middlewares/auth.php
session_start();

function requireRole(array $roles = []) {
    if (!isset($_SESSION['usuario_tipo'])) {
        $_SESSION['usuario_tipo'] = 'anonimo';
    }
    if (empty($roles)) return true;
    if (!in_array($_SESSION['usuario_tipo'], $roles)) {
        header('Location: /sem-permissao');
        exit;
    }
    return true;
}
