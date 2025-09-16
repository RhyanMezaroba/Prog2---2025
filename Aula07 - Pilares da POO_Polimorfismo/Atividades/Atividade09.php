<?php

interface Formatador {
    public function formatar($texto);
}

class Maiusculo implements Formatador {
    public function formatar($texto) {
        return strtoupper($texto);
    }
}

class Minusculo implements Formatador {
    public function formatar($texto) {
        return strtolower($texto);
    }
}

class Capitalizado implements Formatador {
    public function formatar($texto) {
        return ucwords(strtolower($texto));
    }
}

class Mensagem {
    private $formatador;

    public function __construct(Formatador $formatador) {
        $this->formatador = $formatador;
    }

    public function enviar($texto) {
        return $this->formatador->formatar($texto);
    }
}

$texto = "eXEmPlo De mENsaGEM";

$msg1 = new Mensagem(new Maiusculo());
$msg2 = new Mensagem(new Minusculo());
$msg3 = new Mensagem(new Capitalizado());

echo $msg1->enviar($texto) . "<br><br>";
echo $msg2->enviar($texto) . "<br><br>";
echo $msg3->enviar($texto) . "<br><br>";
