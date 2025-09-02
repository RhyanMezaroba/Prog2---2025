<?php
class Produto {
    public string $nome;
    private float $preco;

    public function __construct(string $nome, float $preco) {
        $this->nome = $nome;
        $this->setPreco($preco); // Usa o setter para aplicar validação
    }

    // Getter do preço
    public function getPreco(): float {
        return $this->preco;
    }

    // Setter do preço com validação
    public function setPreco(float $preco): void {
        if ($preco >= 0) {
            $this->preco = $preco;
        } else {
            echo "Erro: O preço não pode ser negativo.<br><br>";
        }
    }
}

// Teste
$p1 = new Produto("Suporte de Celular", 20);

$p2 = new Produto("Popit",-10);

echo "Produto selecionado: " . $p1->nome . "<br>";
echo "Valor do produto: R$ " . number_format($p1->getPreco(), 2, ',', '.') . "<br>";
?>
