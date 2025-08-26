<?php
class Produto {
    public string $nome;
    private float $preco;

    public function __construct(string $nome, float $preco) {
        $this->nome = $nome;
        $this->preco = $preco;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function setPreco(float $preco): void {
        $this->preco = $preco;
    }
}

$p1 = new Produto("Suporte de Celular", 20.0);

// Usando os métodos corretamente:
echo "Produto selecionado: " . $p1->nome . "<br>";
echo "Valor do produto: " . $p1->getPreco() . "<br> <br>";

// Alterando o preço:
$p1->setPreco(25.5);
echo "Novo valor do produto: " . $p1->getPreco() . "<br>";
?>
