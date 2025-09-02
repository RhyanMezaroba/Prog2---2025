<?php
class CarrinhoDeCompras {
    private float $total = 0;
    private array $log = [];

    public function adicionarValor(float $valor): void {
        if ($valor > 0) {
            $this->total += $valor;
            $this->log[] = $valor;
        }
    }

    public function getTotal(): float {
        return $this->total;
    }

    public function exibirTotal(): void {
        echo "Total do carrinho: R$ " . number_format($this->total, 2, ',', '.') . "<br>";
    }

    public function exibirLog(): void {
        if (empty($this->log)) {
            echo "Nenhum item adicionado ao carrinho.<br>";
            return;
        }

        echo "Itens adicionados:<br>";
        foreach ($this->log as $index => $valor) {
            echo ($index + 1) . ". R$ " . number_format($valor, 2, ',', '.') . "<br>";
        }
    }
}

$carrinho = new CarrinhoDeCompras();

$carrinho->adicionarValor(59.90);
$carrinho->adicionarValor(120);
$carrinho->adicionarValor(35.50);

$carrinho->exibirLog();
echo "<br>";
$carrinho->exibirTotal();
?>
