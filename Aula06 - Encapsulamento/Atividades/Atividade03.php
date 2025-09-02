<?php
class Cliente {
    private string $nome;
    private string $cpf;
    private string $telefone;

    public function __construct(string $nome, string $cpf, string $telefone) {
        $this->setNome($nome);
        $this->setCpf($cpf);
        $this->setTelefone($telefone);
    }

    public function setNome(string $nome): void {
        $this->nome = trim($nome);
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setCpf(string $cpf): void {
        $cpfNumeros = preg_replace('/\D/', '', $cpf);
        if (strlen($cpfNumeros) !== 11) {
            throw new InvalidArgumentException("CPF deve conter exatamente 11 dígitos.");
        }
        $this->cpf = $cpfNumeros;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setTelefone(string $telefone): void {
        $telNumeros = preg_replace('/\D/', '', $telefone);
        if (strlen($telNumeros) !== 11) {
            throw new InvalidArgumentException("Telefone deve conter exatamente 11 dígitos.");
        }
        $this->telefone = $telNumeros;
    }

    public function getTelefone(): string {
        return $this->telefone;
    }

    public function exibirDados(): void {
        echo "Nome: {$this->nome}<br>";
        echo "CPF: {$this->cpf}<br>";
        echo "Telefone: {$this->telefone}<br>";
    }
}

echo "<strong>Teste de coesão</strong><br>";
try {
    $cliente = new Cliente("João Silva", "123.456.789-00", "(11) 91234-5678");
    $cliente->exibirDados();
} catch (InvalidArgumentException $e) {
    echo "Erro: " . $e->getMessage();
}

echo "<hr>";
echo "<strong>Acessos dentro da classe (via método):</strong><br>";
$cliente->exibirDados();

echo "<hr><strong>Acessos fora da classe:</strong><br>";
echo "Nome (via getter): {$cliente->getNome()}<br>";
echo "CPF (via getter): {$cliente->getCpf()}<br>";
echo "Telefone (via getter): {$cliente->getTelefone()}<br>";
?>
