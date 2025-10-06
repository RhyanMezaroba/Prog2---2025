<?php

class Coracao {
    public function bater() {
        echo "❤️ Coração batendo...<br>";
    }
}

class Pulmao {
    public function respirar() {
        echo "😤 Pulmões respirando...<br>";
    }
}

class Cerebro {
    public function pensar() {
        echo "🧠 Cérebro processando pensamentos...<br>";
    }
}

class CorpoHumano {
    private $coracao;
    private $pulmao;
    private $cerebro;

    public function __construct() {
        echo "<strong>Corpo humano funcionando:</strong><br><br>";

        $this->coracao = new Coracao();
        $this->pulmao = new Pulmao();
        $this->cerebro = new Cerebro();
    }

    public function viver() {
        $this->coracao->bater();
        $this->pulmao->respirar();
        $this->cerebro->pensar();

        echo "<br><strong>Todos os órgãos estão funcionando em sincronia.</strong><br>";
    }
}

$humano = new CorpoHumano();
$humano->viver();
