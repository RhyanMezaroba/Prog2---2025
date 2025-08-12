<?php
class Calculadora {
    private float $valor1;
    private float $valor2;
    private float $resultado;

    public function __construct(float $valor1 , float $valor2){
        $this->valor1 = $valor1;
        $this->valor2 = $valor2;
        $this->resultado = 0;
    }

    public function somar(): float {
        $this->resultado = $this->valor1 + $this->valor2;
        return $this->resultado;
    }

    public function diminuir(): float {
        $this->resultado = $this->valor1 - $this->valor2;
        return $this->resultado;
    }

    public function multiplicar(): float {
        $this->resultado = $this->valor1 * $this->valor2;
        return $this->resultado;
    }

    public function dividir(): float {
        if ($this->valor2 == 0) {
            throw new Exception("Divisão por zero não é permitida.");
        }
        $this->resultado = $this->valor1 / $this->valor2;
        return $this->resultado;
    }

    public function getResultado(): float {
        return $this->resultado;
    }
}

$calc = new Calculadora(10, 5);

echo "Valores: {$this->valor1} e {$this->valor2}<br>";
echo "Soma: " . $calc->somar() . "<br>";
echo "Subtração: " . $calc->diminuir() . "<br>";
echo "Multiplicação: " . $calc->multiplicar() . "<br>";
echo "Divisão: " . $calc->dividir() . "<br>";

?>
