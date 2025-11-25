<?php
session_start();

// Autoload do Composer
require_once __DIR__ . '/../../vendor/autoload.php';

// Sanitiza os parâmetros da URL
$controller = isset($_GET['c']) ? preg_replace('/[^a-z0-9_]/i', '', strtolower($_GET['c'])) : 'home';
$action     = isset($_GET['a']) ? preg_replace('/[^a-z0-9_]/i', '', strtolower($_GET['a'])) : 'index';

// Monta o nome completo da classe com namespace
$controllerClass = "App\\Controllers\\" . ucfirst($controller) . "Controller";

// Com o autoloader do Composer, não é necessário incluir o arquivo manualmente.
// O autoloader se encarrega de encontrar e carregar a classe.
// Removemos as linhas que checam e incluem o arquivo do controller.

// Verifica se a classe existe dentro do namespace
if (!class_exists($controllerClass)) {
    http_response_code(404);
    echo "<h3>Controller class not found:</h3> <p>{$controllerClass}</p>";
    exit;
}

// Instancia o controlador
$controllerInstance = new $controllerClass();

// Verifica se a action existe
if (!method_exists($controllerInstance, $action)) {
    http_response_code(404);
    echo "<h3>Action not found:</h3> <p>{$action}</p>";
    exit;
}

// Verifica se há um ID
$id = $_GET['id'] ?? null;

// Chama a action levando em conta o ID
if ($id !== null) {
    $controllerInstance->$action($id);
} else {
    $controllerInstance->$action();
}