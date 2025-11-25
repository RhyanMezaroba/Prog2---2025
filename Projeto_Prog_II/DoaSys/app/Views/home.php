<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoaSys - Sistema de Gerenciamento de Doações</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
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
    <custom-navbar></custom-navbar>
    
    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <section class="text-center py-16">
            <h1 class="text-5xl font-bold text-gray-800 mb-6">
                Transformando Vidas através de 
                <span class="text-primary">Doações</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                DoaSys conecta doadores e beneficiários em uma plataforma transparente 
                e eficiente para gerenciamento de doações públicas.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">    
                <!-- Botão Cadastrar Doação -->
                <a href="/DoaSys/App/Views/Donations/Create.php"
                    class="bg-primary hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                    <i data-feather="plus" class="inline mr-2"></i>
                    Cadastrar Doação
                </a>
                <!-- Botão Ver Doações -->
                <a href="/DoaSys/App/migration/router.php?c=donation&a=index"
                    class="bg-secondary hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                    <i data-feather="search" class="inline mr-2"></i>
                    Ver Doações
                </a>
                <!-- Botão Sobre -->
                <a href="/DoaSys/App/Views/Donations/about.php"
                    class="bg-accent hover:bg-yellow-500 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                    <i data-feather="info" class="inline mr-2"></i>
                    Sobre
                </a>
            </div>

        </section>

        <!-- Stats Section -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition duration-300">
                <i data-feather="heart" class="w-12 h-12 text-red-500 mx-auto mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-800">1,247</h3>
                <p class="text-gray-600">Doações Realizadas</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition duration-300">
                <i data-feather="users" class="w-12 h-12 text-primary mx-auto mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-800">856</h3>
                <p class="text-gray-600">Famílias Beneficiadas</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition duration-300">
                <i data-feather="map-pin" class="w-12 h-12 text-secondary mx-auto mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-800">42</h3>
                <p class="text-gray-600">Cidades Atendidas</p>
            </div>
        </section>

        <!-- Features Section -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Como Funciona</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                    <i data-feather="user-plus" class="w-10 h-10 text-primary mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Cadastro Simples</h3>
                    <p class="text-gray-600">Registre doações de forma rápida e organizada com nosso sistema intuitivo.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                    <i data-feather="shield" class="w-10 h-10 text-secondary mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Transparência Total</h3>
                    <p class="text-gray-600">Acompanhe todo o processo de doação desde o registro até a entrega.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                    <i data-feather="bar-chart" class="w-10 h-10 text-accent mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Relatórios Detalhados</h3>
                    <p class="text-gray-600">Gere relatórios completos para análise e tomada de decisões.</p>
                </div>
            </div>
        </section>
    </main>

    <custom-footer></custom-footer>

    <script src="components/navbar.js"></script>
    <script src="components/footer.js"></script>
    <script src="script.js"></script>
    <script>feather.replace();</script>
</body>
</html>