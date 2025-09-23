<?php

//Quarto tem vários Itens (COMPOSIÇÃO)
class Item {
    public $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }
}

class Quarto {
    public $numero;
    public $tipo;
    public $precoNoite;
    public $itens = [];

    public function __construct($numero, $tipo, $precoNoite) {
        $this->numero = $numero;
        $this->tipo = $tipo;
        $this->precoNoite = $precoNoite;
    }

    public function addItem(Item $item) {
        $this->itens[] = $item;
    }
}



