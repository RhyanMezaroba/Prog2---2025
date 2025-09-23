<?php
require_once 'Cliente.php';
require_once 'Quarto.php';

// A classe Reserva mantém referência a um Cliente e a um Quarto (UNIDIRECIONAL)
class Reserva {
    public $cliente;  
    public $quarto;   
    public $dataEntrada;
    public $dataSaida;

    public function __construct(Cliente $cliente, Quarto $quarto, $dataEntrada, $dataSaida) {
        $this->cliente = $cliente;
        $this->quarto = $quarto;
        $this->dataEntrada = $dataEntrada;
        $this->dataSaida = $dataSaida;
    }

    public function calcularTotal() {
        $entrada = new DateTime($this->dataEntrada);
        $saida = new DateTime($this->dataSaida);
        $intervalo = $saida->diff($entrada)->days;
        return $intervalo * $this->quarto->precoNoite;
    }
}

