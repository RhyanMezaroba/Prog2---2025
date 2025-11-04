<?php
require_once 'Aluno.php';

if (isset($_GET['id'])) {
    $repo = new Aluno();
    $repo->deletar($_GET['id']);
    header("Location: listar_alunos.php?msg=" . urlencode("Aluno excluído com sucesso!"));
    exit;
} else {
    echo "ID inválido!";
}
?>
