<?php

class Sessao {
    private $nome;

    public function __construct($nome) {
        $this->nome = $nome;
        echo "Sessão '{$this->nome}' criada.<br>";
    }

    public function __destruct() {
        echo "Sessão '{$this->nome}' destruída.<br>";
    }

    public function getNome() {
        return $this->nome;
    }
}

class BibliotecaDigital {
    private $sessoes = [];

    public function __construct() {
        echo "<strong>Biblioteca Digital iniciada com as sessões:</strong><br>";

        $this->sessoes[] = new Sessao("Literatura");
        $this->sessoes[] = new Sessao("Ciência");
        $this->sessoes[] = new Sessao("História");
    }

    public function listarSessoes() {
        foreach ($this->sessoes as $sessao) {
            echo "📚 " . $sessao->getNome() . "<br>";
        }
    }

    public function __destruct() {
        echo "<br><strong>Biblioteca Digital sendo destruída, sessões também serão destruídas:</strong><br>";
    }
}

$biblioteca = new BibliotecaDigital();
$biblioteca->listarSessoes();

unset($biblioteca);
