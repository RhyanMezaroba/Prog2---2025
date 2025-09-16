<?php

abstract class FiguraGeometrica {
    abstract public function calcularArea();
}

class Quadrado extends FiguraGeometrica {
    private $lado;

    public function __construct($lado) {
        $this->lado = $lado;
    }

    public function calcularArea() {
        return $this->lado * $this->lado;
    }
}

class Circulo extends FiguraGeometrica {
    private $raio;

    public function __construct($raio) {
        $this->raio = $raio;
    }

    public function calcularArea() {
        return pi() * $this->raio * $this->raio;
    }
}

class Retangulo extends FiguraGeometrica {
    private $largura;
    private $altura;

    public function __construct($largura, $altura) {
        $this->largura = $largura;
        $this->altura = $altura;
    }

    public function calcularArea() {
        return $this->largura * $this->altura;
    }
}

$figuras = [
    new Quadrado(4),
    new Circulo(3),
    new Retangulo(5, 2)
];

foreach ($figuras as $f) {
    echo "Área: " . $f->calcularArea() . "<br><br>";
}
?>