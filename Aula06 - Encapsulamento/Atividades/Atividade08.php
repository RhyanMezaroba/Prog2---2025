<?php
class Aluno {
    private string $nome;
    private float $nota;

    public function __construct(string $nome, float $nota) {
        $this->setNome($nome);
        $this->setNota($nota);
    }

    public function setNome(string $nome): void {
        $this->nome = trim($nome);
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNota(float $nota): void {
        if ($nota < 0 || $nota > 10) {
            throw new InvalidArgumentException("Nota deve estar entre 0 e 10.");
        }
        $this->nota = $nota;
    }

    public function getNota(): float {
        return $this->nota;
    }

    public function exibirDados(): void {
        echo "Aluno: {$this->getNome()}<br>";
        echo "Nota: " . number_format($this->getNota(), 1, ',', '.') . "<br>";
    }
}

$aluno1 = new Aluno("Joana Souza", 8.5);
$aluno1->exibirDados();

echo "<hr>";

try {
    $aluno1->setNota(11); // deve lançar erro
} catch (InvalidArgumentException $e) {
    echo "Erro ao alterar nota: " . $e->getMessage() . "<br>";
}
?>
