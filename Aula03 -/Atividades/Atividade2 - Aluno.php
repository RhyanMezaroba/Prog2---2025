<?php
class Aluno {
    private string $nome;
    private string $classe;
    private float $media;

    public function __construct(string $nome , string $classe , float $media){
        $this->nome = $nome;
        $this->classe = $classe;
        $this->media = $media;
    }

    public function verificarAprovacao() {
        echo "O aluno {$this->nome}, da classe {$this->classe}, com média de {$this->media}: ";

        if ($this->media > 7) {
            echo "Moleque é bom mesmo!<br>";
        } elseif ($this->media == 7) {
            echo "Passou raspando kkkkkk<br>";
        } else {
            echo "Seu MADRUGA: REPROVADO!!!<br>";
        }
    }
}

// Criando objetos com os parâmetros corretos
$aluno1 = new Aluno("Thiaguinho", "A2", 8.5);
$aluno2 = new Aluno("Thiagão", "B2", 6.0);
$aluno3 = new Aluno("Mateuzadas", "A1", 7.0);

// Chamando o método verificarAprovacao para cada aluno
$aluno1->verificarAprovacao();
$aluno2->verificarAprovacao();
$aluno3->verificarAprovacao();
?>
