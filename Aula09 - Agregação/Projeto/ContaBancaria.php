<?php

require_once 'Cliente.php';
require_once 'Transacao.php';
require_once 'Banco.php';

class ContaBancaria {
    private $numero;
    private $saldo;

    private $cliente; 

    private $transacoes = []; 

    private $banco; 

    public function __construct(int $numero, Cliente $cliente, Banco $banco, float $saldoInicial = 0.0) {
        $this->numero = $numero;
        $this->cliente = $cliente; 
        $this->banco = $banco;     
        $this->saldo = $saldoInicial;
    }

    public function adicionarTransacao(Transacao $transacao) {
        $this->transacoes[] = $transacao; 
        
    
        if ($transacao->getTipo() === 'Credito') {
            $this->saldo += $transacao->getValor();
        } 
        elseif ($transacao->getTipo() === 'Debito') {
            $this->saldo -= $transacao->getValor();
        }
    }

    
    public function getNumero(): int {
        return $this->numero;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function getCliente(): Cliente {
        return $this->cliente;
    }

    public function getBanco(): Banco {
        return $this->banco;
    }

    public function getTransacoes(): array {
        return $this->transacoes;
    }
}