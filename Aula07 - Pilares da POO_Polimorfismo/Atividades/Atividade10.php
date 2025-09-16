<?php
abstract class Transporte {
    abstract public function calcularTarifa();
}

class Onibus extends Transporte {
    public function calcularTarifa() {
        return 4.50;
    }
}

class Metro extends Transporte {
    public function calcularTarifa() {
        return 5.00;
    }
}

class Taxi extends Transporte {
    private $distancia; // em km
    private $tarifaBase = 6.00;
    private $precoPorKm = 2.50;

    public function __construct($distancia) {
        $this->distancia = $distancia;
    }

    public function calcularTarifa() {
        return $this->tarifaBase + ($this->distancia * $this->precoPorKm);
    }
}

$transportes = [
    new Onibus(),
    new Metro(),
    new Taxi(10) // 10 km
];

foreach ($transportes as $t) {
    echo "Tarifa: R$ " . number_format($t->calcularTarifa(), 2, ',', '.') . "<br><br>";
}
