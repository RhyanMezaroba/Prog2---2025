<?php
// app/rotas/web.php
session_start();

// Caminho base do projeto
$basePath = '/DoaSys/public';

// Captura a URL da requisição
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove o prefixo basePath da URL para roteamento
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
    if ($path === '') $path = '/';
}

$method = $_SERVER['REQUEST_METHOD'];

// Autoload mínimo
spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . "/../controllers/{$class}.php",
        __DIR__ . "/../models/{$class}.php",
        __DIR__ . "/../middlewares/{$class}.php",
        __DIR__ . "/../config/{$class}.php"
    ];
    foreach ($paths as $p) {
        if (file_exists($p)) require_once $p;
    }
});

// Rotas simples e API
if ($path === '/api/cep' && $method === 'GET') {
    header('Content-Type: application/json');
    $cep = isset($_GET['cep']) ? preg_replace('/\D/', '', $_GET['cep']) : '';
    if (!$cep) { http_response_code(400); echo json_encode(['erro' => 'CEP não informado']); exit; }
    $url = "https://viacep.com.br/ws/{$cep}/json/";
    $response = @file_get_contents($url);
    if ($response === false) { http_response_code(500); echo json_encode(['erro' => 'Não foi possível consultar o CEP']); exit; }
    echo $response;
    exit;
}

if ($path === '/api/session' && $method === 'GET') {
    header('Content-Type: application/json');
    echo json_encode([
        'logged' => isset($_SESSION['usuario_id']),
        'usuario_id' => $_SESSION['usuario_id'] ?? null,
        'usuario_nome' => $_SESSION['usuario_nome'] ?? null,
        'usuario_tipo' => $_SESSION['usuario_tipo'] ?? 'anonimo'
    ]);
    exit;
}

// Rota principal — Home
if ($path === '/' || $path === '/home') {
    include __DIR__ . '/../views/home/index.html';
    exit;
}

// Outras rotas
switch ($path) {
    case '/doacoes':
        $ctrl = new DoacaoController();
        if ($method === 'GET') $ctrl->listar();
        break;

    case '/doacoes/nova':
        $ctrl = new DoacaoController();
        if ($method === 'GET') $ctrl->cadastrar($basePath);
        break;

    case '/doacoes/salvar':
        $ctrl = new DoacaoController();
        if ($method === 'POST') $ctrl->salvar();
        break;

    case '/doacoes/editar':
        $ctrl = new DoacaoController();
        if ($method === 'GET') $ctrl->editar();
        break;

    case '/doacoes/atualizar':
        $ctrl = new DoacaoController();
        if ($method === 'POST') $ctrl->atualizar();
        break;

    case '/doacoes/excluir':
        $ctrl = new DoacaoController();
        if ($method === 'POST') $ctrl->excluir();
        break;

    // Auth
    case '/usuario/cadastrar':
        $ctrl = new AuthController();
        if ($method === 'GET') $ctrl->mostrarFormularioRegistro();
        if ($method === 'POST') $ctrl->registrar();
        break;

    case '/login':
        $ctrl = new AuthController();
        if ($method === 'GET') $ctrl->mostrarFormularioLogin();
        if ($method === 'POST') $ctrl->login();
        break;

    case '/logout':
        $ctrl = new AuthController();
        $ctrl->logout();
        break;

    default:
        $possible = __DIR__ . "/../views" . $path;
        if (is_file($possible)) { include $possible; break; }
        http_response_code(404);
        echo "Página não encontrada (404)";
        break;
}