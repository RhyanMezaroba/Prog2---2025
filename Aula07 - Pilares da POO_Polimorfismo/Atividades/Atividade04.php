<?php

abstract class Notificacao {
    abstract public function enviar();
}

class Email extends Notificacao {
    public function enviar() {
        return "Notificação enviada por Email<br><br>";
    }
}

class SMS extends Notificacao {
    public function enviar() {
        return "Notificação enviada por SMS<br><br>";
    }
}

class Push extends Notificacao {
    public function enviar() {
        return "Notificação enviada por Push<br><br>";
    }
}

$notificacoes = [
    new Email(),
    new SMS(),
    new Push()
];

foreach ($notificacoes as $n) {
    echo $n->enviar() . "\n";
}
?>