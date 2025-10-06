<?php

class Tela {
    public function __construct() {
        echo "Tela iniciada.<br>";
    }

    public function __destruct() {
        echo "Tela destruída.<br>";
    }
}

class Bateria {
    public function __construct() {
        echo "Bateria iniciada.<br>";
    }

    public function __destruct() {
        echo "Bateria destruída.<br>";
    }
}

class Camera {
    public function __construct() {
        echo "Câmera iniciada.<br>";
    }

    public function __destruct() {
        echo "Câmera destruída.<br>";
    }
}

class Processador {
    public function __construct() {
        echo "Processador iniciado.<br>";
    }

    public function __destruct() {
        echo "Processador destruído.<br>";
    }
}

class Smartphone {
    private $tela;
    private $bateria;
    private $camera;
    private $processador;

    public function __construct() {
        echo "<strong>Montando smartphone...</strong><br><br>";
        $this->tela = new Tela();
        $this->bateria = new Bateria();
        $this->camera = new Camera();
        $this->processador = new Processador();
        echo "<strong>Smartphone montado.</strong><br><br>";
    }

    public function __destruct() {
        echo "<strong>Smartphone destruído e componentes removidos.</strong><br><br>";
    }
}

$smartphone = new Smartphone();

unset($smartphone);
