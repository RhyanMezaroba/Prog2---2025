<?php
require_once 'classes/Cliente.php';
require_once 'classes/Quarto.php';
require_once 'classes/Reserva.php';

class BancoEmMemoria {
    private $clientes = [];
    private $quartos = [];
    private $reservas = [];

    public function __construct() {
        $this->clientes[] = new Cliente("João Silva", "joao@email.com");
        $this->clientes[] = new Cliente("Maria Oliveira", "maria@email.com");

        $this->quartos[] = new Quarto(101, "Suíte Master com vista para o mar", 500);
        $this->quartos[] = new Quarto(202, "Quarto Luxo com varanda", 350);
        $this->quartos[] = new Quarto(303, "Quarto Standard aconchegante", 200);

        $reserva1 = new Reserva($this->clientes[0], $this->quartos[0], "2025-10-01", "2025-10-04");
        $this->reservas[] = $reserva1;
        $this->clientes[0]->addReserva($reserva1);

        $reserva2 = new Reserva($this->clientes[1], $this->quartos[1], "2025-10-10", "2025-10-12");
        $this->reservas[] = $reserva2;
        $this->clientes[1]->addReserva($reserva2); 
    }

    public function listarClientes() {
        return $this->clientes;
    }

    public function listarQuartos() {
        return $this->quartos;
    }

    public function listarReservas() {
        return $this->reservas;
    }

    public function adicionarCliente(Cliente $cliente) {
        $this->clientes[] = $cliente;
    }

    public function adicionarReserva(Reserva $reserva) {
        $this->reservas[] = $reserva;
        $reserva->cliente->addReserva($reserva);
    }

    public function buscarClientePorEmail($email) {
        foreach ($this->clientes as $cliente) {
            if ($cliente->email === $email) {
                return $cliente;
            }
        }
        return null;
    }

    public function buscarQuartoPorNumero($numero) {
        foreach ($this->quartos as $quarto) {
            if ($quarto->numero == $numero) {
                return $quarto;
            }
        }
        return null;
    }
}
