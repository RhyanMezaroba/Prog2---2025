<?php

class Coracao {
    public function bater() {
        echo "Tum-tum ❤️<br>";
    }
}

class Pessoa {
    private $nome;
    private $coracao;

    public function __construct($nome) {
        $this->nome = $nome;
        $this->coracao = new Coracao();
    }

    public function viver() {
        echo "{$this->nome} está vivo e seu coração está batendo...<br>";
        $this->coracao->bater();
    }
}

$pessoa1 = new Pessoa("João");
$pessoa1->viver();
