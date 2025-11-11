<?php
class DoacaoController {

    public function home() {
        include '../app/views/home/index.html';
    }

    public function listar() {
        include '../app/views/doacoes/doacoes.html';
    }

    public function cadastrar() {
        include '../app/views/doacoes/cadastro.html';
    }
}
