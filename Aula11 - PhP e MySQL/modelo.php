<?php
    abstract class Modelo {
        protected $id;
        public function getId() { return $this->id; }
        public function setId($id) { $this->id = $id; }
        abstract public function validar();
    }
?>