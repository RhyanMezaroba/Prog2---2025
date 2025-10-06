<?php

require_once 'classes/Computador.php';

$pc1 = new Computador(
    "Dell", "XPS 15",
    "Intel Core i7", 3.4,
    "DDR4", 16,
    "SSD", 512
);

$pc2 = new Computador(
    "HP", "Pavilion",
    "AMD Ryzen 5", 3.7,
    "DDR5", 32,
    "HD", 1000
);

$pc1->mostrarInfo();
$pc2->mostrarInfo();

?>