<?php

class Relatorio {
    public function __call($nome, $argumentos) {
        if ($nome === 'gerar') {
            $quantidade = count($argumentos);

            if ($quantidade === 0) {
                return "Relatório padrão gerado";
            } elseif ($quantidade === 1) {
                return "Relatório gerado para: " . $argumentos[0];
            } elseif ($quantidade === 2) {
                return "Relatório de " . $argumentos[0] . " no período " . $argumentos[1];
            } else {
                return "Parâmetros inválidos para gerar relatório";
            }
        }
    }
}

$r = new Relatorio();

echo $r->gerar() . "<br><br>";
echo $r->gerar("Vendas") . "<br><br>";
echo $r->gerar("Financeiro", "Agosto") . "<br><br>";
