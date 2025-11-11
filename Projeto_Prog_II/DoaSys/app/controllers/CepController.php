<?php
// app/controllers/CepController.php

// Permitir requisições de qualquer origem (opcional, para frontend)
header('Content-Type: application/json');

$cep = $_GET['cep'] ?? '';

if (!$cep) {
    echo json_encode(['erro' => 'CEP não informado']);
    exit;
}

$cep = preg_replace('/\D/', '', $cep);

if (strlen($cep) !== 8) {
    echo json_encode(['erro' => 'CEP inválido']);
    exit;
}

$url = "https://viacep.com.br/ws/$cep/json/";
$data = @file_get_contents($url);

if (!$data) {
    echo json_encode(['erro' => 'Não foi possível consultar o CEP']);
    exit;
}
echo $data;