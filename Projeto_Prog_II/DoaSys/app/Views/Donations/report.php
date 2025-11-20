<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - DoaSys</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">

    <custom-navbar></custom-navbar>

    <main class="container mx-auto px-4 py-10">

        <h1 class="text-4xl font-bold text-gray-800 mb-8 flex items-center gap-3">
            <i data-feather="bar-chart-2"></i>
            Relatórios e Estatísticas
        </h1>

        <!-- Cards Resumo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <!-- Total Doações -->
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                <p class="text-gray-500 text-sm">Total de Doações</p>
                <h2 class="text-3xl font-bold text-primary mt-2">128</h2>
            </div>

            <!-- Total Entregues -->
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                <p class="text-gray-500 text-sm">Doações Entregues</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">94</h2>
            </div>

            <!-- Doações Pendentes -->
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                <p class="text-gray-500 text-sm">Pendentes</p>
                <h2 class="text-3xl font-bold text-yellow-600 mt-2">34</h2>
            </div>
        </div>

        <!-- Gráfico
             (você pode integrar Chart.js depois)
        -->
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Distribuição por Tipo</h2>

            <div class="w-full h-64 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500">
                <p>Gráfico aqui (Chart.js ou API futura)</p>
            </div>
        </div>

    </main>

    <custom-footer></custom-footer>

    <script>
        feather.replace();
    </script>

</body>
</html>
