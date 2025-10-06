<?php

class Transacao {
    private $id;
    private $valor;
    private $tipo; 

    public function __construct(int $id, float $valor, string $tipo) {
        $this->id = $id;
        $this->valor = $valor;
        $this->tipo = $tipo;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getValor(): float {
        return $this->valor;
    }

    public function getTipo(): string {
        return $this->tipo;
    }
}