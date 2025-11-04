<?php
require_once 'Aluno.php';

try {
    $aluno = new Aluno();
    $aluno->setNome($_POST['nome']);
    $aluno->setIdade($_POST['idade']);
    $aluno->setEmail($_POST['email']);
    $aluno->setCurso($_POST['curso']);
    $aluno->validar();

    if (!empty($_POST['id'])) {
        $aluno->setId($_POST['id']);
        $aluno->atualizar($aluno);
        $msg = "Aluno atualizado com sucesso!";
    } else {
        $aluno->salvar($aluno);
        $msg = "Aluno cadastrado com sucesso!";
    }

    header("Location: listar_alunos.php?msg=" . urlencode($msg));
    exit;
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
