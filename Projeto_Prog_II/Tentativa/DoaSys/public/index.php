<?php
// bootstrap básico se já não existir
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Se o projeto estiver em /DoaSys, removemos esse prefixo para roteamento interno
$base = '/DoaSys';
$path = $uri;
if (strpos($path, $base) === 0) {
    $path = substr($path, strlen($base));
}
$path = $path ?: '/';

// Roteador simples: mapeia POST /doacoes/salvar para o controller
if ($path === '/doacoes/salvar' || $path === '/doacoes/salvar/') {
    require_once __DIR__ . '/app/controllers/DoacaoController.php';
    $ctrl = new DoacaoController();
    $ctrl->salvar();
    exit;
}

require_once __DIR__ . '/../app/rotas/web.php';