<?php

class Departamento {
    private $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }
}

class Universidade {
    private $departamentos = [];

    public function __construct() {
        echo "<strong>Universidade criada com os seguintes departamentos:</strong><br><br>";

        $this->departamentos[] = new Departamento("Exatas");
        $this->departamentos[] = new Departamento("Humanas");
        $this->departamentos[] = new Departamento("Saúde");
    }

    public function listarDepartamentos() {
        foreach ($this->departamentos as $departamento) {
            echo "🏛️ " . $departamento->getNome() . "<br>";
        }

        echo "<br><strong>Total: " . count($this->departamentos) . " departamentos</strong><br>";
    }
}

$universidade = new Universidade();
$universidade->listarDepartamentos();
