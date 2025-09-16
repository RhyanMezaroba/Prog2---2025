<?php
    class Calculadora {
        public function somar($a, $b, $c = null) {
            if ($c !== null) {
                return $a + $b + $c;
            }
            return $a + $b;
        }
    }

    $calc = new Calculadora();

    echo $calc->somar(2, 3) . "<br><br>";
    echo "\n";
    echo $calc->somar(1, 2, 3) . "<br><br>";
?>