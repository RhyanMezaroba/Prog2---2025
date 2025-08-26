<?php
    class Usuario {
        private string $nome;
        private string $senha;

        public function __construct(string $nome, string $senha) {
            $this->nome = $nome;
            $this->senha = $senha;
        }

        public function verificarSenha(string $senhaDigitada): bool {
            return $this->senha === $senhaDigitada;
        }

        public function getNome(): string {
            return $this->nome;
        }
    }
    
    $usuario = new Usuario("admin", "1234");

    
    $senhaTeste = "1234"; // Faça alteração para testar
    if ($usuario->verificarSenha($senhaTeste)) {
        echo "Senha CORRETA para o usuário: " . $usuario->getNome() . "<br>";
    } else {
        echo "Senha INCORRETA para o usuário: " . $usuario->getNome() . "<br>";
    }

?>
