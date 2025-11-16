<?php
// app/rotas/web.php
session_start();

// Autoload mínimo (ou use composer autoload)
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

// rotas simples
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Endpoint API CEP (mantido)
if ($path === '/api/cep' && $method === 'GET') {
    header('Content-Type: application/json');
    $cep = isset($_GET['cep']) ? preg_replace('/\D/', '', $_GET['cep']) : '';
    if (!$cep) { http_response_code(400); echo json_encode(['erro' => 'CEP não informado']); exit; }
    $url = "https://viacep.com.br/ws/{$cep}/json/";
    $response = @file_get_contents($url);
    if ($response === false) { http_response_code(500); echo json_encode(['erro' => 'Não foi possível consultar o CEP']); exit; }
    $data = json_decode($response, true);
    echo json_encode($data); exit;
}

// Session info endpoint (para navbar dinâmica)
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

    //ROTA PRINCIPAL — HOME
if ($path === '/' || $path === '/home') {
    include __DIR__ . '/../views/home/index.html';
    exit;
}

   // OUTRAS ROTAS

switch ($path) {

    case '/doacoes':
        require_once __DIR__ . '/../controllers/DoacaoController.php';
        $ctrl = new DoacaoController();
        if ($method === 'GET') $ctrl->listar();
        break;

    case '/doacoes/nova':
        require_once __DIR__ . '/../controllers/DoacaoController.php';
        $ctrl = new DoacaoController();
        if ($method === 'GET') $ctrl->cadastrar();
        break;

    case '/doacoes/salvar':
        require_once __DIR__ . '/../controllers/DoacaoController.php';
        $ctrl = new DoacaoController();
        if ($method === 'POST') $ctrl->salvar();
        break;

    case '/doacoes/editar':
        require_once __DIR__ . '/../controllers/DoacaoController.php';
        $ctrl = new DoacaoController();
        if ($method === 'GET') $ctrl->editar();
        break;

    case '/doacoes/atualizar':
        require_once __DIR__ . '/../controllers/DoacaoController.php';
        $ctrl = new DoacaoController();
        if ($method === 'POST') $ctrl->atualizar();
        break;

    case '/doacoes/excluir':
        require_once __DIR__ . '/../controllers/DoacaoController.php';
        $ctrl = new DoacaoController();
        if ($method === 'POST') $ctrl->excluir();
        break;

    // Auth
    case '/usuario/cadastrar':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $ctrl = new AuthController();
        if ($method === 'GET') $ctrl->mostrarFormularioRegistro();
        if ($method === 'POST') $ctrl->registrar();
        break;

    case '/login':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $ctrl = new AuthController();
        if ($method === 'GET') $ctrl->mostrarFormularioLogin();
        if ($method === 'POST') $ctrl->login();
        break;

    case '/logout':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $ctrl = new AuthController();
        $ctrl->logout();
        break;

    // View estática caso exista
    default:
        $possible = __DIR__ . "/../views" . $path;
        if (is_file($possible)) {
            include $possible;
            break;
        }
        http_response_code(404);
        echo "Página não encontrada (404)";
        break;
}
