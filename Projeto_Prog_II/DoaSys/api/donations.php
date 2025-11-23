<?php
    // API simples que retorna JSON de doações (aceita filtros via GET)
    require_once __DIR__ . '/../App/Models/Donation.php';

    $donationModel = new donationModel();

    //Filtros via GET
    $tipo = isset($_GET['tipo']) && $_GET['tipo'] !== '' ? trim($_GET['tipo']) : null;
    $dataInicio = isset($_GET['data_inicio']) && $_GET['data_inicio'] !== '' ? trim($_GET['data_inicio']) : null;
    $dataFim = isset($_GET['data_fim']) && $_GET['data_fim'] !== '' ? trim($_GET['data_fim']) : null;

    //Programação defensiva - evitar erros no Model caso os métodos não existam
    try {
        if (method_exists($donationModel, 'getFiltered')) {
            $rows = $donationModel->getFiltered($tipo, $dataInicio, $dataFim);
        } else {
            $rows = $donationModel->getAll();
        }
        
        // Retorna JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($rows);
    } 

    // Tratamento de erros - Recebimento de Json Válido
    catch (Exception $e) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Erro ao buscar doações: ' . $e->getMessage()]);
    }
?>