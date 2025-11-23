<?php
session_start();

$controller = isset($_GET['c']) ? preg_replace('/[^a-z0-9_]/i', '', $_GET['c']) : 'home';
$action     = isset($_GET['a']) ? preg_replace('/[^a-z0-9_]/i', '', $_GET['a']) : 'index';

$controllerClass = ucfirst($controller) . 'Controller';

// Caminho REAL dos seus controllers
$controllerFile = __DIR__ . '/../Controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "Controller file not found: $controllerFile";
    exit;
}

require_once $controllerFile;

// A classe deve existir dentro do arquivo
if (!class_exists($controllerClass)) {
    http_response_code(500);
    echo "Controller class not found: {$controllerClass}";
    exit;
}

$ctrl = new $controllerClass();

// Verifica se o método existe
if (!method_exists($ctrl, $action)) {
    http_response_code(404);
    echo "Action not found: {$action}";
    exit;
}

// Se tiver parâmetro id, passa para o controller
$id = $_GET['id'] ?? null;

if ($id !== null) {
    $ctrl->$action($id);
} else {
    $ctrl->$action();
}
