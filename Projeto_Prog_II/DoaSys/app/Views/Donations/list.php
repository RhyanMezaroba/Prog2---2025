<?php
require_once __DIR__ . '/../../Models/donationModel.php';
$donationModel = new donationModel();
$tipo = isset($_GET['tipo']) && $_GET['tipo'] !== '' ? trim($_GET['tipo']) : null;
$dataInicio = isset($_GET['data_inicio']) && $_GET['data_inicio'] !== '' ? trim($_GET['data_inicio']) : null;
$dataFim = isset($_GET['data_fim']) && $_GET['data_fim'] !== '' ? trim($_GET['data_fim']) : null;

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10; // itens por página

$paged = $donationModel->getPaged($page, $perPage, $tipo, $dataInicio, $dataFim);
$donations = $paged['data'];
$total = $paged['total'];
$totalPages = (int)ceil($total / $perPage);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Doações - DoaSys</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="style.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        accent: '#F59E0B'
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">

    <!-- NAVBAR GLOBAL -->
    <custom-navbar></custom-navbar>

    <main class="container mx-auto px-4 py-8">

        <!-- Cabeçalho -->
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i data-feather="list" class="inline mr-3"></i>
                        Lista de Doações
                    </h1>
                    <p class="text-lg text-gray-600">
                        Gerencie e visualize todas as doações cadastradas
                    </p>
                </div>

                <div class="flex items-center gap-3 mt-4 sm:mt-0">
                    <a href="/DoaSys/app/migration/router.php?c=home&a=index" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Home</a>
                    <a href="/DoaSys/app/Views/Donations/create.php"
                    class="bg-primary hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                        <i data-feather="plus" class="inline mr-2"></i>
                        Nova Doação
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 card-hover">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="form-group">
                    <label class="form-label">Tipo</label>
                    <select id="filtroTipo" name="tipo" class="form-input w-full">
                        <option value="">Todos os tipos</option>
                        <option value="alimentos" <?php echo ($tipo==='alimentos')? 'selected' : ''; ?>>Alimentos</option>
                        <option value="roupas" <?php echo ($tipo==='roupas')? 'selected' : ''; ?>>Roupas</option>
                        <option value="medicamentos" <?php echo ($tipo==='medicamentos')? 'selected' : ''; ?>>Medicamentos</option>
                        <option value="dinheiro" <?php echo ($tipo==='dinheiro')? 'selected' : ''; ?>>Dinheiro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Data Inicial</label>
                    <input id="filtroDataInicio" name="data_inicio" type="date" value="<?php echo htmlspecialchars($dataInicio ?? ''); ?>" class="form-input w-full">
                </div>

                <div class="form-group">
                    <label class="form-label">Data Final</label>
                    <input id="filtroDataFim" name="data_fim" type="date" value="<?php echo htmlspecialchars($dataFim ?? ''); ?>" class="form-input w-full">
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-4">
                <form method="get" class="inline">
                    <input type="hidden" name="tipo" id="formTipoHidden" value="<?php echo htmlspecialchars($tipo ?? ''); ?>">
                    <input type="hidden" name="data_inicio" id="formDataInicioHidden" value="<?php echo htmlspecialchars($dataInicio ?? ''); ?>">
                    <input type="hidden" name="data_fim" id="formDataFimHidden" value="<?php echo htmlspecialchars($dataFim ?? ''); ?>">
                    <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                        <i data-feather="filter" class="inline mr-2"></i>
                        Aplicar Filtros
                    </button>
                </form>
            </div>
        </div>

        <!-- LISTA DE DOAÇÕES — RENDERIZADA NO SERVIDOR -->
        <div id="lista-doacoes" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php if (empty($donations)): ?>
                <div class="col-span-1 bg-white p-6 rounded-lg">Nenhuma doação encontrada.</div>
            <?php else: ?>
                <?php foreach ($donations as $d): ?>
                    <?php
                        $status = htmlspecialchars($d['status'] ?? '');
                        $categoria = htmlspecialchars($d['categoria'] ?? $d['tipo'] ?? '');
                        $titulo = htmlspecialchars($d['titulo'] ?? $d['descricao'] ?? '');
                        $benef = htmlspecialchars($d['beneficiario_nome'] ?? $d['beneficiario'] ?? '');
                        $doador = htmlspecialchars($d['nome_usuario'] ?? $d['doador'] ?? '-');
                        $valorDisplay = '-';
                        if (isset($d['valor']) && $d['valor'] !== '' && is_numeric($d['valor'])) {
                            $valorDisplay = 'R$ ' . number_format((float)$d['valor'], 2, ',', '.');
                        } elseif (!empty($d['quantidade'])) {
                            $valorDisplay = htmlspecialchars($d['quantidade']) . ' itens';
                        }
                        $dataStr = $d['data_doacao'] ?? $d['data'] ?? null;
                        $dataFormatada = $dataStr ? implode('/', array_reverse(explode('-', $dataStr))) : '-';
                    ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo ($status==='entregue')? 'bg-green-100 text-green-800' : (($status==='pendente')? 'bg-yellow-100 text-yellow-800' : (($status==='cancelada')? 'bg-red-100 text-red-800':'bg-gray-100 text-gray-700')); ?>">
                                    <?php echo ucfirst($status); ?>
                                </span>

                                <span class="ml-2 inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    <?php echo $categoria; ?>
                                </span>
                            </div>

                            <button class="text-gray-400 hover:text-primary transition duration-300">
                                <i data-feather="more-vertical"></i>
                            </button>
                        </div>

                        <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo $titulo; ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo $benef; ?></p>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Doador</p>
                                <p class="font-medium"><?php echo $doador; ?></p>
                            </div>

                            <div>
                                <p class="text-gray-500">Valor / Qtde</p>
                                <p class="font-medium"><?php echo $valorDisplay; ?></p>
                            </div>

                            <div>
                                <p class="text-gray-500">Data</p>
                                <p class="font-medium"><?php echo $dataFormatada; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Paginação -->
        <?php if ($totalPages > 1): ?>
        <div class="flex justify-center mt-12">
            <nav class="flex items-center gap-2" aria-label="Paginação">
                <?php $prev = max(1, $page - 1); ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page'=>$prev])); ?>" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i data-feather="chevron-left"></i>
                </a>

                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <?php if ($p == $page): ?>
                        <span class="px-3 py-2 bg-primary text-white rounded-lg font-medium"><?php echo $p; ?></span>
                    <?php else: ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page'=>$p])); ?>" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"><?php echo $p; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php $next = min($totalPages, $page + 1); ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page'=>$next])); ?>" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i data-feather="chevron-right"></i>
                </a>
            </nav>
        </div>
        <?php endif; ?>

    </main>

    <!-- FOOTER GLOBAL -->
    <custom-footer></custom-footer>

    <script src="components/navbar.js"></script>
    <script src="components/footer.js"></script>

    <script>
        feather.replace();

        // mantém os valores dos filtros no formulário visível
        document.getElementById('filtroTipo')?.addEventListener('change', function(e){ document.getElementById('formTipoHidden').value = this.value; });
        document.getElementById('filtroDataInicio')?.addEventListener('change', function(e){ document.getElementById('formDataInicioHidden').value = this.value; });
        document.getElementById('filtroDataFim')?.addEventListener('change', function(e){ document.getElementById('formDataFimHidden').value = this.value; });
    </script>

</body>
</html>
