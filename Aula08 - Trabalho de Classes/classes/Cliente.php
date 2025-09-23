<?php

//Cliente tem várias reservas (AGREGAÇÃO)
class Cliente {
    public $nome;
    public $email;
    public $reservas = []; 

    public function __construct($nome, $email) {
        $this->nome = $nome;
        $this->email = $email;
    }

    public function addReserva(Reserva $reserva) {
        $this->reservas[] = $reserva;
    }
}


