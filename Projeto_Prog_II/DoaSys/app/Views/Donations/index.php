<?php include __DIR__ . '/../partials/header.php'; ?>

<style>
    .donations-container {
        max-width: 900px;
        margin: 20px auto;
        padding: 10px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-new {
        display: inline-block;
        background: #007BFF;
        color: #fff;
        padding: 10px 16px;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 20px;
    }

    .btn-new:hover {
        background: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th, table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background: #f2f2f2;
        text-align: left;
    }

    .status {
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .pendente { background: #ffeeba; color: #8a6d3b; }
    .em_andamento { background: #cce5ff; color: #004085; }
    .concluida { background: #d4edda; color: #155724; }
    .cancelada { background: #f8d7da; color: #721c24; }

</style>

<div class="donations-container">

    <h1>Lista de Doações</h1>

    <a class="btn-new" href="/donations/create">+ Nova Doação</a>

    <?php if (empty($donations)): ?>
        <p>Nenhuma doação cadastrada ainda.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Cidade</th>
                    <th>Doador</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($donations as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['titulo']); ?></td>
                        <td><?= htmlspecialchars($d['categoria']); ?></td>
                        <td><?= htmlspecialchars($d['cidade']); ?></td>

                        <td>
                            <?php if ($d['usuario_id'] === null): ?>
                                <span>Anônimo</span>
                            <?php else: ?>
                                Usuário #<?= $d['usuario_id']; ?>
                            <?php endif; ?>
                        </td>

                        <td>
                            <span class="status <?= $d['status']; ?>">
                                <?= ucfirst(str_replace('_',' ', $d['status'])); ?>
                            </span>
                        </td>

                        <td><?= date("d/m/Y", strtotime($d['criado_em'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
