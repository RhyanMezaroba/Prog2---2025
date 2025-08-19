<?php
class Aluno {
    public string $nome;
    private int $matricula;
    private array $notas = [];
    private float $media = 0.0;

    public function __construct(string $nome, int $matricula) {
        $this->nome = $nome;
        $this->matricula = $matricula;
    }

    public function getMatricula(): int {
        return $this->matricula;
    }

    public function adicionarNota(float $nota): void {
        if ($nota >= 0 && $nota <= 10) {
            $this->notas[] = $nota;
            $this->calcularMedia();
        }
    }

    private function calcularMedia(): void {
        $totalNotas = count($this->notas);
        if ($totalNotas > 0) {
            $this->media = array_sum($this->notas) / $totalNotas;
        }
    }

    public function situacao(): string {
        return $this->media >= 7 ? "Aprovado" : "Reprovado";
    }

    public function numMatricula(): int {
        return $this->matricula;
    }
}

// Exemplo de uso:
$matriculaAleatoria = random_int(1000, 9999);
$aluno = new Aluno("Jhonathans Felipesss", $matriculaAleatoria);
$aluno->adicionarNota(8.5);
$aluno->adicionarNota(7.0);
$aluno->adicionarNota(6.0);

echo "Nome: {$aluno->nome}<br>";
echo "Matrícula: {$aluno->getMatricula()}<br>";
echo "Situação: {$aluno->situacao()}<br>";
?>
