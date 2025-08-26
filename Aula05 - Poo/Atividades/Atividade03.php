<?php
class Conta {
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
        }
    }

    public function sacar(float $valor): void {
        if ($valor > 0 && $this->saldo >= $valor) {
            $this->saldo -= $valor;
        } else {
            echo "Saque não permitido: saldo insuficiente ou valor inválido.<br>";
        }
    }
}

// Teste
$conta1 = new Conta("Carlos Silva", 500, random_int(0, 10000));
$conta2 = new Conta("Ana Oliveira", 1200, random_int(0, 10000));

$conta1->depositar(250);
$conta2->depositar(300);

$conta1->sacar(200);  // Teste de saque
$conta2->sacar(2000); // Deve exibir mensagem de erro

$conta1->exibirDados();
$conta2->exibirDados();
?>
