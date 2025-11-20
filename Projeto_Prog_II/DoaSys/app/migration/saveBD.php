<?php
// endpoint público para salvar doação
session_start();

// inclui Model e Donation com caminhos relativos corretos e tolerantes a variações de namespace/nomes
$modelFile = __DIR__ . '/../Models/Model.php';
$donationFileCandidates = [
    __DIR__ . '/../Models/Donation.php',
    __DIR__ . '/../Models/DonationModel.php',
    __DIR__ . '/../Models/Donation.class.php'
];

if (!file_exists($modelFile)) {
    http_response_code(500);
    echo 'Arquivo Model.php não encontrado em: ' . $modelFile;
    exit;
}
require_once $modelFile;

// se Model estiver em namespace App\Core, cria alias para compatibilidade com codebase legacy
if (!class_exists('Model') && class_exists('App\\Core\\Model')) {
    class_alias('App\\Core\\Model', 'Model');
}

// inclui Donation (tenta várias alternativas)
$donationIncluded = false;
foreach ($donationFileCandidates as $f) {
    if (file_exists($f)) {
        require_once $f;
        $donationIncluded = true;
        break;
    }
}
if (!$donationIncluded) {
    http_response_code(500);
    echo 'Arquivo Donation não encontrado. Procure por Donation.php em App/Models/';
    exit;
}

// se a classe Donation estiver em namespace diferente, cria alias se necessário
if (!class_exists('Donation')) {
    if (class_exists('App\\Models\\Donation')) {
        class_alias('App\\Models\\Donation', 'Donation');
    } elseif (class_exists('\\Donation')) {
        class_alias('\\Donation', 'Donation');
    }
}

// agora garante que a classe Model e Donation existam
if (!class_exists('Model')) {
    http_response_code(500);
    echo 'Classe Model não encontrada após carregar Model.php';
    exit;
}
if (!class_exists('Donation')) {
    http_response_code(500);
    echo 'Classe Donation não encontrada após carregar Donation.php';
    exit;
}

// helper simples
function input(string $name, $default = null) {
    return isset($_POST[$name]) ? trim($_POST[$name]) : $default;
}

$anonymous = isset($_POST['anonymous']) && $_POST['anonymous'] == '1';

$donationModel = new Donation();

$data = [];

// se usuário logado e não anônimo, vincula usuario_id
$data['usuario_id'] = (!$anonymous && !empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : null;

// campos esperados (remova/adicione conforme seu formulário)
$data['titulo'] = input('titulo', '');
$data['descricao'] = input('descricao', '');
$data['categoria'] = input('categoria', '');
$data['quantidade'] = input('quantidade', null);
$data['valor'] = input('valor', null);
$data['data_doacao'] = input('data_doacao', null);

$data['beneficiario_nome'] = input('beneficiario_nome', '');
$data['beneficiario_cpf'] = input('beneficiario_cpf', '');

$data['cidade'] = input('cidade', '');
$data['bairro'] = input('bairro', '');
$data['endereco'] = input('endereco', '');
$data['cep'] = input('cep', '');

// status padrão
$data['status'] = 'pendente';

try {
    // validação mínima no servidor
    $errors = [];
    if ($data['titulo'] === '') $errors[] = 'Título é obrigatório.';
    if ($data['categoria'] === '') $errors[] = 'Categoria é obrigatória.';
    if ($data['quantidade'] === '' || $data['quantidade'] === null) $errors[] = 'Quantidade é obrigatória.';
    if ($data['beneficiario_nome'] === '') $errors[] = 'Beneficiário é obrigatório.';
    if ($data['cep'] === '') $errors[] = 'CEP é obrigatório.';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header('Location: /DoaSys/App/Views/Donations/create.php');
        exit;
    }

    $insertId = $donationModel->create($data);
    $_SESSION['flash']['success'] = 'Doação cadastrada com sucesso. ID: ' . $insertId;
    header('Location: /DoaSys/App/Views/Donations/list.php');
    exit;

} catch (Exception $e) {
    $_SESSION['flash']['error'] = 'Erro ao salvar doação: ' . $e->getMessage();
    $_SESSION['old'] = $_POST;
    header('Location: /DoaSys/App/Views/Donations/create.php');
    exit;
}
?>