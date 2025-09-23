<?php
require_once 'banco.php';

// Criar instância do banco em memória
$banco = new BancoEmMemoria();

$msgSucesso = '';
$msgErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $numeroQuarto = intval($_POST['numero_quarto'] ?? 0);
    $dataEntrada = $_POST['data_entrada'] ?? '';
    $dataSaida = $_POST['data_saida'] ?? '';

    if ($nome && $email && $numeroQuarto && $dataEntrada && $dataSaida) {
        $cliente = $banco->buscarClientePorEmail($email);
        if (!$cliente) {
            $cliente = new Cliente($nome, $email);
            $banco->adicionarCliente($cliente); 
        }

        $quarto = $banco->buscarQuartoPorNumero($numeroQuarto);
        if ($quarto) {
            $reserva = new Reserva($cliente, $quarto, $dataEntrada, $dataSaida);
            $banco->adicionarReserva($reserva); 
            $msgSucesso = "Reserva criada com sucesso!";
        } else {
            $msgErro = "Quarto não encontrado.";
        }
    } else {
        $msgErro = "Preencha todos os campos.";
    }
}

$reservas = $banco->listarReservas();
$quartos = $banco->listarQuartos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Reservas - Hotel Apache'Jhonson</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<header>
    <h1>Hotel Apache'Jhonson</h1>
    <p>Seu refúgio de tranquilidade e conforto</p>
</header>

<nav>
    <a href="index.php">Início</a>
    <a href="#">Sobre</a>
    <a href="#">Quartos</a>
    <a href="reservas.php">Reservas</a>
    <a href="#">Contato</a>
</nav>

<section>
    <h2>Reservas Ativas</h2>

    <?php if ($msgSucesso): ?>
        <p style="color:green; font-weight:bold;"><?= htmlspecialchars($msgSucesso) ?></p>
    <?php endif; ?>

    <?php if ($msgErro): ?>
        <p style="color:red; font-weight:bold;"><?= htmlspecialchars($msgErro) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Quarto</th>
                <th>Data Entrada</th>
                <th>Data Saída</th>
                <th>Total (R$)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
            <tr>
                <td><?= htmlspecialchars($reserva->cliente->nome) ?></td>
                <td><?= htmlspecialchars($reserva->cliente->email) ?></td>
                <td><?= htmlspecialchars($reserva->quarto->tipo) ?></td>
                <td><?= htmlspecialchars($reserva->dataEntrada) ?></td>
                <td><?= htmlspecialchars($reserva->dataSaida) ?></td>
                <td><?= number_format($reserva->calcularTotal(), 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<section>
    <h2>Nova Reserva</h2>
    <form method="POST" action="reservas.php">
        <label>Nome do Cliente:<br>
            <input type="text" name="nome" required>
        </label><br><br>

        <label>Email do Cliente:<br>
            <input type="email" name="email" required>
        </label><br><br>

        <label>Número do Quarto:<br>
            <select name="numero_quarto" required>
                <option value="">Selecione um quarto</option>
                <?php foreach ($quartos as $quarto): ?>
                    <option value="<?= $quarto->numero ?>"><?= $quarto->numero ?> - <?= htmlspecialchars($quarto->tipo) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <label>Data de Entrada:<br>
            <input type="date" name="data_entrada" required>
        </label><br><br>

        <label>Data de Saída:<br>
            <input type="date" name="data_saida" required>
        </label><br><br>

        <button type="submit">Criar Reserva</button>
    </form>
</section>

<f
