<?php
class Livro {
    private string $titulo;
    private string $autor;
    private DateTime $anoPublicacao;
    private int $numeroPaginas;
    private bool $disponivel;

    public function __construct(string $titulo, string $autor, string $dataPublicacao, int $numeroPaginas, bool $disponivel) {
        if (empty(trim($titulo))) {
            throw new InvalidArgumentException("O título não pode ser vazio.");
        }

        if (empty(trim($autor))) {
            throw new InvalidArgumentException("O autor não pode ser vazio.");
        }

        $data = new DateTime($dataPublicacao);
        $anoAtual = (int) date('Y');
        if ((int)$data->format('Y') > $anoAtual) {
            throw new InvalidArgumentException("O ano de publicação não pode ser no futuro.");
        }

        if ($numeroPaginas <= 0) {
            throw new InvalidArgumentException("O número de páginas deve ser positivo.");
        }

        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anoPublicacao = $data;
        $this->numeroPaginas = $numeroPaginas;
        $this->disponivel = $disponivel;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function getAutor(): string {
        return $this->autor;
    }

    public function getAnoPublicacao(): string {
        return $this->anoPublicacao->format('Y');
    }

    public function getNumeroPaginas(): int {
        return $this->numeroPaginas;
    }

    public function estaDisponivel(): bool {
        return $this->disponivel;
    }
}


$livro = new Livro("Minecraft", "Steve Steven", "1979-11-08", 753, true);

echo "Título: " . $livro->getTitulo() . "<br>";
echo "Autor: " . $livro->getAutor() . "<br>";
echo "Ano de Publicação: " . $livro->getAnoPublicacao() . "<br>";
echo "Páginas: " . $livro->getNumeroPaginas() . "<br>";
echo "Disponibilidade: " . ($livro->estaDisponivel() ? "Sim" : "Não") . "<br>";

?>