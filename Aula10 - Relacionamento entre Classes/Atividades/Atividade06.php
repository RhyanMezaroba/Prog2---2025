<?php

class Modulo {
    private $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }
}

class Aplicativo {
    private $modulos = [];

    public function __construct() {
        echo "<strong>Aplicativo iniciado com os seguintes módulos:</strong><br><br>";

        $this->modulos[] = new Modulo("Login");
        $this->modulos[] = new Modulo("Dashboard");
        $this->modulos[] = new Modulo("Config");
    }

    public function listarModulosAtivos() {
        foreach ($this->modulos as $modulo) {
            echo "✅ " . $modulo->getNome() . "<br>";
        }

        echo "<br><strong>Total de módulos ativos: " . count($this->modulos) . "</strong><br>";
    }
}

$app = new Aplicativo();
$app->listarModulosAtivos();
