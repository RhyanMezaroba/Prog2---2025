<?php
require_once 'Conexao.php';
require_once 'Repositorio.php';
require_once 'Modelo.php';

class Aluno extends Modelo implements Repositorio {
    private $nome;
    private $idade;
    private $email;
    private $curso;

    // ========== Getters e Setters ==========
    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; }

    public function getIdade() { return $this->idade; }
    public function setIdade($idade) { $this->idade = $idade; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getCurso() { return $this->curso; }
    public function setCurso($curso) { $this->curso = $curso; }

    // ========== Validação ==========
    public function validar() {
        if (empty($this->nome) || empty($this->email)) {
            throw new Exception("Nome e email são obrigatórios");
        }
        if ($this->idade < 16 || $this->idade > 100) {
            throw new Exception("Idade deve estar entre 16 e 100 anos");
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }
        return true;
    }

    // ========== CREATE ==========
    public function salvar($obj) {
        $pdo = Conexao::conectar();
        $sql = "INSERT INTO alunos (nome, idade, email, curso)
                VALUES (:nome, :idade, :email, :curso)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $obj->getNome());
        $stmt->bindValue(':idade', $obj->getIdade());
        $stmt->bindValue(':email', $obj->getEmail());
        $stmt->bindValue(':curso', $obj->getCurso());
        $stmt->execute();
    }

    // ========== READ ==========
    public function listar() {
        $pdo = Conexao::conectar();
        $sql = "SELECT * FROM alunos ORDER BY nome";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $pdo = Conexao::conectar();
        $sql = "SELECT * FROM alunos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ========== UPDATE ==========
    public function atualizar($obj) {
        $pdo = Conexao::conectar();
        $sql = "UPDATE alunos 
                SET nome = :nome, idade = :idade, email = :email, curso = :curso
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $obj->getNome());
        $stmt->bindValue(':idade', $obj->getIdade());
        $stmt->bindValue(':email', $obj->getEmail());
        $stmt->bindValue(':curso', $obj->getCurso());
        $stmt->bindValue(':id', $obj->getId());
        $stmt->execute();
    }

    // ========== DELETE ==========
    public function deletar($id) {
        $pdo = Conexao::conectar();
        $sql = "DELETE FROM alunos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
