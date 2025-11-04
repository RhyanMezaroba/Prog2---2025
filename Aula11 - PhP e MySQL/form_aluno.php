<?php
require_once 'Aluno.php';

$modoEdicao = false;
$aluno = null;

if (isset($_GET['id'])) {
    $repo = new Aluno();
    $dados = $repo->buscarPorId($_GET['id']);
    if ($dados) {
        $modoEdicao = true;
        $aluno = $dados;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $modoEdicao ? 'Editar Aluno' : 'Cadastrar Aluno' ?></title>
</head>
<body>
    <h2><?= $modoEdicao ? 'Editar Aluno' : 'Cadastrar Novo Aluno' ?></h2>

    <form action="salvar_aluno.php" method="post">
        <?php if ($modoEdicao): ?>
            <input type="hidden" name="id" value="<?= $aluno['id'] ?>">
        <?php endif; ?>

        <label>Nome:</label>
        <input type="text" name="nome" required value="<?= $aluno['nome'] ?? '' ?>"><br><br>

        <label>Idade:</label>
        <input type="number" name="idade" required value="<?= $aluno['idade'] ?? '' ?>"><br><br>

        <label>Email:</label>
        <input type="email" name="email" required value="<?= $aluno['email'] ?? '' ?>"><br><br>

        <label>Curso:</label>
        <input type="text" name="curso" required value="<?= $aluno['curso'] ?? '' ?>"><br><br>

        <button type="submit"><?= $modoEdicao ? 'Salvar Alterações' : 'Cadastrar' ?></button>
        <a href="listar_alunos.php">Voltar</a>
    </form>
</body>
</html>
