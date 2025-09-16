<?php

class Animal {
    public function falar() {
        return "O animal faz um som.<br><br>";
    }
}

class Cachorro extends Animal {
    public function falar() {
        return "O cachorro late: Au au!<br><br>";
    }
}

class Gato extends Animal {
    public function falar() {
        return "O gato mia: Miau!<br><br>";
    }
}

$meuCachorro = new Cachorro();
$meuGato = new Gato();

echo $meuCachorro->falar();
echo "\n";
echo $meuGato->falar();

?>
