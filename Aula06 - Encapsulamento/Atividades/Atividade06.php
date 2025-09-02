<?php
class Pedido {
    private array $itens = [];

    public function adicionarItem(string $item): void {
        $this->itens[] = $item;
    }

    public function listarItens(): array {
        return $this->itens;
    }

    public function exibirItens(): void {
        if (empty($this->itens)) {
            echo "Nenhum item no pedido.<br>";
            return;
        }

        echo "Itens do pedido:<br>";
        foreach ($this->itens as $index => $item) {
            echo ($index + 1) . ". " . htmlspecialchars($item) . "<br>";
        }
    }
}

$pedido = new Pedido();

$pedido->adicionarItem("Caneta azul");
$pedido->adicionarItem("Caderno");
$pedido->adicionarItem("Mochila");

$itensVestuario = [
    "Camiseta", "Calça Jeans", "Tênis", "Jaqueta", "Boné"
];

$itensTecnologia = [
    "Smartphone", "Fone de ouvido", "Carregador portátil", "Mouse", "Teclado"
];

$itensBeleza = [
    "Perfume", "Base líquida", "Batom", "Escova de cabelo", "Protetor solar"
];

foreach ($itensVestuario as $item) {
    $pedido->adicionarItem($item);
}

foreach ($itensTecnologia as $item) {
    $pedido->adicionarItem($item);
}

foreach ($itensBeleza as $item) {
    $pedido->adicionarItem($item);
}

$pedido->exibirItens();
?>
