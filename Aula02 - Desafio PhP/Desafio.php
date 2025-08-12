<?php
class User {   
    private $nome = "João";
    private $email = "joao@exemplo.com";
    private $idade = 25;
    
    public function __construct($nome, $email, $idade){
        $this->nome = $nome;
        $this->email = $email;
        $this->idade = $idade;
    }

    public function exibir(){
        echo "Nome: " . $this->nome . "<br>";
        echo "Email: " . $this->email . "<br>";
        echo "Idade: " . $this->idade . "<br>";
    }

    public function ehMaiorDeIdade(){
        return $this->idade >= 18;
    }
}

$usuario = new User("João", "joao@exemplo.com", 25);

$usuario->exibir();

if ($usuario->ehMaiorDeIdade()) {
    echo "O usuário é maior de idade.";
} else {
    echo "O usuário é menor de idade.";
}
?>
