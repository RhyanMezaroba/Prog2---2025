<?php
class Funcionario {
    public string $nome;
    protected float $salario; // Utilizei Protected para ser acessado pela subclasse

    public function __construct(string $nome, float|int $salario) {
        $this->nome = $nome;
        $this->salario = (float) $salario;
    }

    public function getSalario(): float {
        return $this->salario;
    }

    public function exibirDados(): void {
        echo "Funcionário: {$this->nome}<br>";
        echo "Salário: R$ " . number_format($this->salario, 2, ',', '.') . "<br><br>";
    }
}

class Gerente extends Funcionario {

    public function setSalario(float $novoSalario): void {
        if ($novoSalario > 0) {
            $this->salario = $novoSalario;
        }
    }

    // Você também pode sobrescrever o método exibirDados, se quiser mostrar algo a mais
    public function exibirDados(): void {
        echo "Gerente: {$this->nome}<br>";
        echo "Salário: R$ " . number_format($this->salario, 2, ',', '.') . "<br><br>";
    }
}

// Testando
$gerente = new Gerente("Mariana Costa", 8000);
$gerente->exibirDados();

$gerente->setSalario(9500);
echo "Após aumento:<br>";
$gerente->exibirDados();
?>
