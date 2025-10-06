<?php

class Armazenamento {
    private string $tipo;
    private int $capacidadeGB;

    public function __construct(string $tipo, int $capacidadeGB) {
        $this->tipo = $tipo;
        $this->capacidadeGB = $capacidadeGB;
    }

    public function mostrarInfo(): void {
        echo "Armazenamento: {$this->tipo}, {$this->capacidadeGB}GB<br>";
    }
}

?>