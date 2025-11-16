<?php

require_once __DIR__ . '/../app/rotas/web.php';

// Se nenhuma rota for encontrada, carregar a home
if (!isset($_GET['route']) || $_GET['route'] === '') {
    include __DIR__ . '/../app/views/home/index.php';
    exit;
}
