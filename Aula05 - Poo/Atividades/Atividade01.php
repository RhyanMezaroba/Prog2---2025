<?php
    class Produto{
        public string $nome;
        public float $preco;

        public function __construct(string $nome, $preco)
        {
            $this->nome = $nome;
            $this->preco = $preco;
        }
    }

    $p1 = new Produto("Suporte de Celular","20");

    echo "Produto selecionado: " . $produto->nome . "<br>";
    echo "Valor do produto: ". $produto->preco ."<br>";
?>