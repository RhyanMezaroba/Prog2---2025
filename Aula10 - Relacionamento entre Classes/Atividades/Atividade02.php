<?php

class Motor {
    public function __construct() {
        echo "Motor ligado.<br>";
    }

    public function __destruct() {
        echo "Motor destruído.<br>";
    }
}

class Carro {
    private $motor;

    public function __construct() {
        $this->motor = new Motor();
        echo "Carro criado.<br>";
    }

    public function __destruct() {
        echo "Carro destruído.<br>";
    }
}

$carro = new Carro();
unset($carro);
