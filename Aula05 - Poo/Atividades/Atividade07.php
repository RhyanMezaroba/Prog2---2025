<?php
    class Pedido {
        private array $itens = [];

        // Adiciona um item ao pedido
        public function adicionarItem(string $item): void {
            $this->itens[] = $item;
        }

        // Lista todos os itens do pedido
        public function listarItens(): void {
            if (empty($this->itens)) {
                echo "Nenhum item no pedido.<br>";
            } else {
                echo "Itens do Pedido:<br>";
                foreach ($this->itens as $indice => $item) {
                    echo ($indice + 1) . ". " . htmlspecialchars($item) . "<br>";
                }
            }
        }
    }

    echo "<hr>";
    echo "<strong>Exemplo de Pedido:</strong><br>";

    $pedido = new Pedido(); // Para testar, adicione novos itens
    $pedido->adicionarItem("Notebook Lenovo");
    $pedido->adicionarItem("Mouse sem fio");
    $pedido->adicionarItem("Mouse Pad");
    $pedido->adicionarItem("HeadSet");
    $pedido->adicionarItem("Webcam Logitech");
    $pedido->adicionarItem("Led 5 metros");

    $pedido->listarItens();

?>
