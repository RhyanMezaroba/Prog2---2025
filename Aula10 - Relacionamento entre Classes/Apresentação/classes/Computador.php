<?php

require_once 'CPU.php';
require_once 'Memoria.php';
require_once 'Armazenamento.php';

class Computador {
    private string $marca;
    private string $modelo;
    
    private CPU $cpu;
    private Memoria $memoria;
    private Armazenamento $armazenamento;

    public function __construct(string $marca, string $modelo, string $cpuModelo, float $cpuClock, string $tipoMemoria, int $memoriaGB, string $tipoArmazenamento, int $armazenamentoGB) {
        $this->marca = $marca;
        $this->modelo = $modelo;

        // Composição: componentes criados internamente
        $this->cpu = new CPU($cpuModelo, $cpuClock);
        $this->memoria = new Memoria($tipoMemoria, $memoriaGB);
        $this->armazenamento = new Armazenamento($tipoArmazenamento, $armazenamentoGB);
    }

    public function mostrarInfo(): void {
        echo "<h3>Computador: {$this->marca} - {$this->modelo}</h3>";
        $this->cpu->mostrarInfo();
        $this->memoria->mostrarInfo();
        $this->armazenamento->mostrarInfo();
        echo "<hr>";
    }
}

?>