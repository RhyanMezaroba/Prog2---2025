<?php
class Usuario {
    private string $nome;
    private string $senha;

    public function __construct(string $nome, string $senha) {
        $this->setNome($nome);
        $this->setSenha($senha);
    }

    public function setNome(string $nome): void {
        $this->nome = trim($nome);
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setSenha(string $senha): void {
        if (strlen($senha) < 6) {
            throw new InvalidArgumentException("A senha deve ter pelo menos 6 caracteres.");
        }
        $this->senha = $senha;
    }

    public function verificarSenha(string $senhaDigitada): bool {
        return $this->senha === $senhaDigitada;
    }
}

$usuario = new Usuario("Maria Oliveira", "senha123");

echo "Usuário: " . $usuario->getNome() . "<br>";
echo "Senha correta? " . ($usuario->verificarSenha("senha123") ? "Sim" : "Não") . "<br>";
echo "Senha incorreta? " . ($usuario->verificarSenha("senhaErrada") ? "Sim" : "Não") . "<br>";
?>
