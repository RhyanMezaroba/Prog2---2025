<?php

class Memoria {
    private string $tipo;
    private int $tamanhoGB;

    public function __construct(string $tipo, int $tamanhoGB) {
        $this->tipo = $tipo;
        $this->tamanhoGB = $tamanhoGB;
    }

    public function mostrarInfo(): void {
        echo "Memória: {$this->tipo}, {$this->tamanhoGB}GB<br>";
    }
}

?>