<?php

abstract class Veiculo {
    abstract public function mover();
}

class Carro extends Veiculo {
    public function mover() {
        return "O carro está se movendo pelas estradas";
    }
}

class Bicicleta extends Veiculo {
    public function mover() {
        return "A bicicleta está sendo pedalada na ciclovia";
    }
}

class Aviao extends Veiculo {
    public function mover() {
        return "O avião está voando pelos céus";
    }
}

$veiculos = [
    new Carro(),
    new Bicicleta(),
    new Aviao()
];

foreach ($veiculos as $v) {
    echo $v->mover() . "<br><br>";
}
