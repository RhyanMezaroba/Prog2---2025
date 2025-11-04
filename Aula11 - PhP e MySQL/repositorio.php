<?php
    interface Repositorio {
        public function salvar($obj);
        public function listar();
        public function buscarPorId($id);
        public function atualizar($obj);
        public function deletar($id);
    }
?>