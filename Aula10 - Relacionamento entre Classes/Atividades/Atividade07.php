<?php

class PonteiroHora {
    private $hora = 1;

    public function avançar() {
        $this->hora = ($this->hora + 1) % 24;
    }

    public function getValor() {
        return str_pad($this->hora, 2, "0", STR_PAD_LEFT);
    }
}

class PonteiroMinuto {
    private $minuto = 0;

    public function avançar() {
        $this->minuto = ($this->minuto + 1) % 60;
    }

    public function getValor() {
        return str_pad($this->minuto, 2, "0", STR_PAD_LEFT);
    }

    public function zerou() {
        return $this->minuto === 0;
    }
}

class PonteiroSegundo {
    private $segundo = 0;

    public function avançar() {
        $this->segundo = ($this->segundo + 1) % 60;
    }

    public function getValor() {
        return str_pad($this->segundo, 2, "0", STR_PAD_LEFT);
    }

    public function zerou() {
        return $this->segundo === 0;
    }
}

class Relogio {
    private $hora;
    private $minuto;
    private $segundo;

    public function __construct() {
        $this->hora = new PonteiroHora();
        $this->minuto = new PonteiroMinuto();
        $this->segundo = new PonteiroSegundo();
    }

    public function avançarTempo() {
        $this->segundo->avançar();

        if ($this->segundo->zerou()) {
            $this->minuto->avançar();

            if ($this->minuto->zerou()) {
                $this->hora->avançar();
            }
        }
    }

    public function exibirHora() {
        echo "🕒 " . $this->hora->getValor() . ":" .
                     $this->minuto->getValor() . ":" .
                     $this->segundo->getValor() . "<br>";
    }
}

$relogio = new Relogio();

for ($i = 0; $i < 125; $i++) {
    $relogio->avançarTempo();
    $relogio->exibirHora();
}
