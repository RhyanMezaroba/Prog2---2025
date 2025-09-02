<?php
class Funcionario {
    private string $nome;
    protected float $salario;

    public function __construct(string $nome, float $salario) {
        $this->setNome($nome);
        $this->setSalario($salario);
    }

    public function setNome(string $nome): void {
        $this->nome = trim($nome);
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setSalario(float $salario): void {
        if ($salario < 0) {
            throw new InvalidArgumentException("Salário não pode ser negativo.");
        }
        $this->salario = $salario;
    }

    public function getSalario(): float {
        return $this->salario;
    }

    public function exibirDados(): void {
        echo "Nome: {$this->getNome()}<br>";
        echo "Salário base: R$ " . number_format($this->getSalario(), 2, ',', '.') . "<br>";
    }
}

class Gerente extends Funcionario {
    private float $bonus = 0;

    public function definirBonus(float $valor): void {
        if ($valor < 0) {
            throw new InvalidArgumentException("Bônus não pode ser negativo.");
        }
        $this->bonus = $valor;
    }

    public function getBonus(): float {
        return $this->bonus;
    }

    public function getSalarioTotal(): float {
        return $this->salario + $this->bonus;
    }

    public function exibirDados(): void {
        echo "Nome: {$this->getNome()}<br>";
        echo "Salário base: R$ " . number_format($this->salario, 2, ',', '.') . "<br>";
        echo "Bônus: R$ " . number_format($this->bonus, 2, ',', '.') . "<br>";
        echo "Salário total com bônus: R$ " . number_format($this->getSalarioTotal(), 2, ',', '.') . "<br>";
    }
}

$gerente = new Gerente("Lucas Andrade", 5000);
$gerente->definirBonus(1500);
$gerente->exibirDados();
?>
