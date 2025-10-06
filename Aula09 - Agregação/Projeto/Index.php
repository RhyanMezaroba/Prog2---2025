<?php

require_once 'Cliente.php';
require_once 'Transacao.php';
require_once 'Banco.php';
require_once 'ContaBancaria.php';


echo "<h2>1. Criação de Objetos Independentes</h2>";


$cliente1 = new Cliente(1, "Alice Silva");
echo "Cliente criado: ID {$cliente1->getId()} - {$cliente1->getNome()}<br>";


$bancoA = new Banco(1001, "Banco Agregador");
echo "Banco criado: ID {$bancoA->getId()} - {$bancoA->getNome()}<br>";

$transacao1 = new Transacao(101, 500.00, "Credito");
$transacao2 = new Transacao(102, 150.00, "Debito");
echo "Transação 1 criada: {$transacao1->getTipo()} de R$ {$transacao1->getValor()}<br>";
echo "Transação 2 criada: {$transacao2->getTipo()} de R$ {$transacao2->getValor()}<br>";


echo "<hr>";

echo "<h2>2. Implementação das Agregações</h2>";

$conta1 = new ContaBancaria(98765, $cliente1, $bancoA, 1000.00);
echo "Conta criada: {$conta1->getNumero()} (Saldo: R$ {$conta1->getSaldo()})<br>";
echo "   -> Cliente Agregado: {$conta1->getCliente()->getNome()}<br>";
echo "   -> Banco Conhecido: {$conta1->getBanco()->getNome()}<br>";

echo "<br>";

$conta1->adicionarTransacao($transacao1);
$conta1->adicionarTransacao($transacao2);
echo "Transações adicionadas. Novo saldo: R$ {$conta1->getSaldo()}<br>";

echo "<br>";

$bancoA->adicionarConta($conta1); 
echo "Conta adicionada ao Banco. Total de contas no {$bancoA->getNome()}: " . count($bancoA->getContas()) . "<br>";

echo "<hr>";


?>