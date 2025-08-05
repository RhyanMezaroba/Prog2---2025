<?php
    #1) Olá, Mundo
    echo "Olá, Programação Orientada a Objeto! <br>";

    echo "<br>";

    #2) Variáveis e tipos
    $nome = "João";
    $idade = 20;
    echo "Meu nome é " , $nome, " e tenho " , $idade , "<br>";

    echo "<br>";

    #3)Primeira Classe
    #4)Construtor em Ação
    class Pessoa {
        private $nome = "Jailson Mendes";
        private $idade = 57;
        
        function __construct($nome = "Jailson Mendes", $idade = 57){
            $this->nome = $nome;
            $this->idade = $idade;
        }

        function apresentar(){
            return "Me chamo {$this->nome} e tenho {$this->idade} anos! <br>";
        }    

        function apresentar2(){
            return "Me chamo {$this->nome} e fiz {$this->idade} anos, estou de aniverssário! <br>";
        }    
      
        #5) Visibilidade
        function getNome(){
            return $this->nome;
        }
        function getIdade(){
            return $this->idade;
        }
        
        #6)Método com parâmetro
        function aniverssario(){
            $this->idade += 1;
        }
    }    
    $pessoa1 = new Pessoa();
    echo $pessoa1->apresentar();

    $pessoa1->aniverssario();
    echo $pessoa1->apresentar2();

    echo "<br>";

    #7)Classe Produto
    class Produto {
        public $name = "Coca Branca";
        public $price = 5;
        public $quantity = 30;

        function __construct($name = "Coca Branca", $price = 10, $quantity = 30) {
            $this->name = $name;
            $this->price = $price;
            $this->quantity = $quantity;
        }

        function valorTotal() {
            return $this->price * $this->quantity;
        }
    }

    $produto1 = new Produto();
    echo "Produto: {$produto1->name} <br>";
    echo "Preço unitátio: R$ {$produto1->price} <br>";
    echo "Quantidade: {$produto1->quantity} <br>";
    echo "Total em estoque: R$ " . $produto1->valorTotal() , "<br>";
    

?>