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

                <a href="/../DoaSys/app/views/doacoes/cadastro.html"
                class="bg-primary hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105 mt-4 sm:mt-0">
                    <i data-feather="plus" class="inline mr-2"></i>
                    Nova Doação
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 card-hover">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="form-group">
                    <label class="form-label">Tipo</label>
                    <select id="filtroTipo" class="form-input w-full">
                        <option value="">Todos os tipos</option>
                        <option value="alimentos">Alimentos</option>
                        <option value="roupas">Roupas</option>
                        <option value="medicamentos">Medicamentos</option>
                        <option value="dinheiro">Dinheiro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Data Inicial</label>
                    <input id="filtroDataInicio" type="date" class="form-input w-full">
                </div>

                <div class="form-group">
                    <label class="form-label">Data Final</label>
                    <input id="filtroDataFim" type="date" class="form-input w-full">
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-4">
                <button onclick="carregarDoacoes()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                    <i data-feather="filter" class="inline mr-2"></i>
                    Aplicar Filtros
                </button>
            </div>
        </div>

        <!-- LISTA DE DOAÇÕES — GERADA VIA JS -->
        <div id="lista-doacoes" class="grid grid-cols-1 lg:grid-cols-2 gap-6"></div>

        <!-- Paginação (Futuro) -->
        <div class="flex justify-center mt-12">
            <nav class="flex items-center gap-2">
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i data-feather="chevron-left"></i>
                </button>

                <button class="px-3 py-2 bg-primary text-white rounded-lg font-medium">1</button>

                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">2</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">3</button>

                <button class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i data-feather="chevron-right"></i>
                </button>
            </nav>
        </div>

    </main>

    <!-- FOOTER GLOBAL -->
    <custom-footer></custom-footer>

    <script src="components/navbar.js"></script>
    <script src="components/footer.js"></script>

    <script>
        feather.replace();

        // substitui array hardcoded por carregamento via API
        let doacoes = [];

        function gerarCard(doacao) {
            const statusClasses = {
                entregue: "bg-green-100 text-green-800",
                pendente: "bg-yellow-100 text-yellow-800",
                cancelada: "bg-red-100 text-red-800"
            };

            const valorDisplay = (doacao.valor && !isNaN(doacao.valor)) 
                ? "R$ " + parseFloat(doacao.valor).toFixed(2) 
                : ((doacao.quantidade) ? (doacao.quantidade + " itens") : '-');

            const dataStr = doacao.data_doacao ?? doacao.data ?? null;
            const dataFormatada = dataStr ? dataStr.split("-").reverse().join("/") : '-';

            return `
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium ${statusClasses[doacao.status] ?? 'bg-gray-100 text-gray-700'}">
                            ${(doacao.status ?? '').charAt(0).toUpperCase() + (doacao.status ?? '').slice(1)}
                        </span>

                        <span class="ml-2 inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            ${doacao.categoria ?? doacao.tipo ?? ''}
                        </span>
                    </div>

                    <button class="text-gray-400 hover:text-primary transition duration-300">
                        <i data-feather="more-vertical"></i>
                    </button>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-2">${doacao.titulo ?? doacao.descricao ?? ''}</h3>
                <p class="text-gray-600 mb-4">${doacao.beneficiario_nome ?? doacao.beneficiario ?? ''}</p>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Doador</p>
                        <p class="font-medium">${doacao.nome_usuario ?? doacao.doador ?? '-'}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Valor / Qtde</p>
                        <p class="font-medium">${valorDisplay}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Data</p>
                        <p class="font-medium">${dataFormatada}</p>
                    </div>
                </div>
            </div>`;
        }

        async function fetchDoacoes(tipo = '', dataInicio = '', dataFim = '') {
            const params = new URLSearchParams();
            if (tipo) params.append('tipo', tipo);
            if (dataInicio) params.append('data_inicio', dataInicio);
            if (dataFim) params.append('data_fim', dataFim);

            // ajuste o caminho conforme sua URL base (em Laragon pode ser /DoaSys/api/donations.php)
            const url = '/DoaSys/api/donations.php' + (params.toString() ? ('?' + params.toString()) : '');
            const res = await fetch(url, { cache: 'no-store' });
            if (!res.ok) {
                console.error('Erro ao carregar doações', res.status);
                return [];
            }
            return await res.json();
        }

        // CARREGA DOAÇÕES NA TELA usando a API
        async function carregarDoacoes() {
            const lista = document.getElementById("lista-doacoes");
            lista.innerHTML = "";

            const tipoFiltro = (document.getElementById("filtroTipo").value || "").trim();
            const dataInicio = (document.getElementById("filtroDataInicio").value || "").trim();
            const dataFim = (document.getElementById("filtroDataFim").value || "").trim();

            // busca já filtrada pelo servidor
            try {
                doacoes = await fetchDoacoes(tipoFiltro, dataInicio, dataFim);
            } catch (err) {
                console.error(err);
                lista.innerHTML = `<div class="col-span-1 bg-white p-6 rounded-lg">Erro ao carregar doações.</div>`;
                return;
            }

            if (!doacoes || doacoes.length === 0) {
                lista.innerHTML = `
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center col-span-1">
                        <p class="text-gray-600">Nenhuma doação encontrada para os filtros aplicados.</p>
                    </div>`;
                feather.replace();
                return;
            }

            doacoes.forEach(d => {
                lista.innerHTML += gerarCard(d);
            });

            feather.replace();
        }

        // chama no carregamento inicial
        carregarDoacoes();
    </script>

</body>
</html>
