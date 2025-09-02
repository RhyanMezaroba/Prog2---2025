<?php
class ContaBancaria {
    private string $titular;
    private float $saldo;
    private int $numero;

    public function __construct(string $titular, float|int $saldo, int $numero) {
        $this->titular = $titular;
        $this->saldo = (float) $saldo;
        $this->numero = (int) $numero;
    }

    public function numeroConta(): int {
        return $this->numero;
    }

    public function getTitular(): string {
        return $this->titular;
    }

    public function exibirDados(): void {
        echo "Titular: {$this->titular}<br>";
        echo "Número da Conta: {$this->numero}<br>";
        echo "Saldo: R$ " . number_format($this->saldo, 2, ',', '.') . "<br><br>";
    }

    public function depositar(float $valor): void {
        if ($valor > 0) {
            $this->saldo += $valor;
            echo "Depósito de R$ " . number_format($valor, 2, ',', '.') . " realizado com sucesso.<br><br>";
        } else {
            echo "Valor de depósito inválido.<br>";
        }
    }

    public function sacar(float $valor): void {
        if ($valor > 0 && $this->saldo >= $valor) {
            $this->saldo -= $valor;
            echo "Saque de R$ " . number_format($valor, 2, ',', '.') . " realizado com sucesso.<br><br>";
        } else {
            echo "Saque não permitido: saldo insuficiente ou valor inválido.<br><br>";
        }
    }
}

// Teste
$conta1 = new ContaBancaria("Carlos Silva", 500, random_int(1000, 9999));
$conta2 = new ContaBancaria("Ana Oliveira", 1200, random_int(1000, 9999));

$conta1->depositar(250);
$conta2->depositar(300);

$conta1->sacar(200);    // Saque permitido
$conta2->sacar(2000);   // Saque não permitido (saldo insuficiente)

$conta1->exibirDados();
$conta2->exibirDados();
?>
