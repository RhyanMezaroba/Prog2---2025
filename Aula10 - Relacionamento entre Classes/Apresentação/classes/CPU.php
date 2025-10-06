<?php

class CPU {
    private string $modelo;
    private float $clockGHz;

    public function __construct(string $modelo, float $clockGHz) {
        $this->modelo = $modelo;
        $this->clockGHz = $clockGHz;
    }

    public function mostrarInfo(): void {
        echo "CPU: {$this->modelo}, Clock: {$this->clockGHz}GHz<br>";
    }
}

?>