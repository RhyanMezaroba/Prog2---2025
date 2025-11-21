<?php
// API simples que retorna JSON de doações (aceita filtros via GET)
require_once __DIR__ . '/../App/Models/Donation.php';

$donationModel = new donationModel();

$tipo = isset($_GET['tipo']) && $_GET['tipo'] !== '' ? trim($_GET['tipo']) : null;
$dataInicio = isset($_GET['data_inicio']) && $_GET['data_inicio'] !== '' ? trim($_GET['data_inicio']) : null;
$dataFim = isset($_GET['data_fim']) && $_GET['data_fim'] !== '' ? trim($_GET['data_fim']) : null;

// Use método filtrado (se disponível) ou getAll como fallback
try {
    if (method_exists($donationModel, 'getFiltered')) {
        $rows = $donationModel->getFiltered($tipo, $dataInicio, $dataFim);
    } else {
        $rows = $donationModel->getAll();
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rows);
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'Erro ao buscar doações: ' . $e->getMessage()]);
}
?>