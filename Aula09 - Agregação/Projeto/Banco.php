<?php

require_once 'ContaBancaria.php';

class Banco {
    private $id;
    private $nome;
    
    private $contas = [];

    public function __construct(int $id, string $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function adicionarConta(ContaBancaria $conta) {
        $this->contas[] = $conta; 
    }

  
    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getContas(): array {
        return $this->contas;
    }
}