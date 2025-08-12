<?php
class ContaBancaria {
    private string $titular;
    private float $saldo;

    public function __construct(string $titular , float|int $saldo){
        $this->titular = $titular;
        $this->saldo = (float) $saldo;
    }

    public function consultarSaldo(): void {
        echo "Titular: {$this->titular}, Saldo: R$ {$this->saldo}<br><br>";
    }

    public function depositar(float|int $valor): void {
        echo "DEPÓSITO<br><br>";

        if ($valor > 0){
            $this->saldo += $valor;
            echo "Valor R$ {$valor}. Depósito feito com sucesso!<br><br>";
        } else {
            echo "Valor inválido<br><br>";
        }
    }

    public function sacar(float|int $valor): void {
        echo "SAQUE<br><br>";

        if ($valor > 0){
            $this->saldo -= $valor;
            echo "Valor R$ {$valor}. Saque feito com sucesso!<br><br>";
        } else {
            echo "Valor inválido<br><br>";
        }
    }
}

$c1 = new ContaBancaria("Rhyan Mezaroba", 1000);
$c1->consultarSaldo();
$c1->depositar(100);
$c1->sacar(50);
$c1->consultarSaldo();
?>
