<?php

class PlacaMae {
    public function __construct() {
        echo "------------------------------<br>";
        echo "Placa-mãe instalada.<br>";
    }
}

class Processador {
    public function __construct() {
        echo "Processador instalado.<br>";
    }
}

class MemoriaRAM {
    public function __construct() {
        echo "Memória RAM instalada.<br>";
        echo "------------------------------<br>";
    }
}

class Computador {
    private $placaMae;
    private $processador;
    private $memoriaRAM;

    public function __construct() {
        echo "<strong>Iniciando montagem do computador...</strong><br><br>";

        $this->placaMae = new PlacaMae();
        $this->processador = new Processador();
        $this->memoriaRAM = new MemoriaRAM();

        echo "<strong>Computador montado com sucesso!</strong><br>";
        echo "==============================<br>";
    }
}

$pc = new Computador();
