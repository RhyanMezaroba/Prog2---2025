<?php
// Front controller simples: chama App\Controllers\<Controller>Controller::<action>
session_start();

$controller = isset($_REQUEST['c']) ? preg_replace('/[^a-z0-9_]/i','', $_REQUEST['c']) : 'home';
$action     = isset($_REQUEST['a']) ? preg_replace('/[^a-z0-9_]/i','', $_REQUEST['a']) : 'index';

$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile  = __DIR__ . '/../controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "Controller file not found: {$controllerFile}";
    exit;
}

require_once $controllerFile;

if (!class_exists($controllerClass)) {
    http_response_code(500);
    echo "Controller class not found: {$controllerClass}";
    exit;
}

$ctrl = new $controllerClass();
$id = $_REQUEST['id'] ?? null;

if (!method_exists($ctrl, $action)) {
    http_response_code(404);
    echo "Action not found: {$action}";
    exit;
}

if ($id !== null) $ctrl->$action($id); else $ctrl->$action();
?>