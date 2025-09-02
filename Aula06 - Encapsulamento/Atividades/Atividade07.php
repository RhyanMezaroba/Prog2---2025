<?php
class Carro {
    private string $nome;
    private int $velocidade = 0;

    public function __construct(string $nome) {
        $this->nome = $nome;
    }

    public function acelerar(int $valor): void {
        if ($valor < 0) return;
        $this->velocidade += $valor;
        if ($this->velocidade > 200) {
            $this->velocidade = 200;
        }
    }

    public function frear(int $valor): void {
        if ($valor < 0) return;
        $this->velocidade -= $valor;
        if ($this->velocidade < 0) {
            $this->velocidade = 0;
        }
    }

    public function getVelocidade(): int {
        return $this->velocidade;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function exibirEstado(): void {
        echo "Carro: {$this->getNome()}<br>";
        echo "Velocidade atual: {$this->getVelocidade()} km/h<br><br>";
    }
}

$carro1 = new Carro("Fusca Turbo");
$carro1->acelerar(50);
$carro1->exibirEstado();

$carro1->acelerar(180);
$carro1->exibirEstado();

$carro1->frear(100);
$carro1->exibirEstado();

$carro1->frear(200);
$carro1->exibirEstado();
?>
