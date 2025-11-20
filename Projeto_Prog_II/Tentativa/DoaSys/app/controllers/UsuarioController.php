<?php
// app/controllers/UsuarioController.php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    public function cadastrar() {
        include __DIR__ . '/../views/auth/registro.php';
    }

    public function listar() {
        $usuarios = Usuario::listarTodos();
        include __DIR__ . '/../views/admin/usuarios.php';
    }
}
