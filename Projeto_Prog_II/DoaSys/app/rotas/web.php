<?php
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if ($requestPath === '/api/cep' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        header('Content-Type: application/json');
        $cep = isset($_GET['cep']) ? preg_replace('/[^0-9]/', '', $_GET['cep']) : '';

        if (!$cep) {
            http_response_code(400);
            echo json_encode(['erro' => 'CEP não informado']);
            exit;
        }

        $url = "https://viacep.com.br/ws/{$cep}/json/";
        $response = file_get_contents($url);

        if ($response === false) {
            http_response_code(500);
            echo json_encode(['erro' => 'Não foi possível consultar o CEP']);
            exit;
        }

        $data = json_decode($response, true);

        if (isset($data['erro']) && $data['erro'] === true) {
            http_response_code(404);
            echo json_encode(['erro' => 'CEP não encontrado']);
            exit;
        }

        echo json_encode($data);
        exit;
    }
?>
