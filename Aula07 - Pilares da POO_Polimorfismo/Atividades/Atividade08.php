<?php

abstract class Impressora {
    abstract public function imprimir();
}

class PDF extends Impressora {
    public function imprimir() {
        return "Imprimindo documento em PDF";
    }
}

class Texto extends Impressora {
    public function imprimir() {
        return "Imprimindo documento de texto";
    }
}

class Imagem extends Impressora {
    public function imprimir() {
        return "Imprimindo imagem";
    }
}

$documentos = [
    new PDF(),
    new Texto(),
    new Imagem()
];

foreach ($documentos as $d) {
    echo $d->imprimir() . "<br><br>";
}
?>