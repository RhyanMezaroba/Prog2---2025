<?php
require_once 'Aluno.php';

$repo = new Aluno();
$alunos = $repo->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos</title>
</head>
<body>
    <h2>Lista de Alunos</h2>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['msg']) ?></p>
    <?php endif; ?>

    <a href="form_aluno.php">Cadastrar Novo Aluno</a>
    <br><br>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Idade</th>
            <th>Email</th>
            <th>Curso</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($alunos as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['nome']) ?></td>
            <td><?= $a['idade'] ?></td>
            <td><?= htmlspecialchars($a['email']) ?></td>
            <td><?= htmlspecialchars($a['curso']) ?></td>
            <td>
                <a href="form_aluno.php?id=<?= $a['id'] ?>">Editar</a> |
                <a href="deletar_aluno.php?id=<?= $a['id'] ?>" onclick="return confirm('Deseja realmente excluir este aluno?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
