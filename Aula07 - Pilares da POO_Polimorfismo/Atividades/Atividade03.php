<?php
    abstract class Pagamento {
        abstract public function processar();
    }

    class Cartao extends Pagamento {
        public function processar() {
            return "Pagamento processado com Cartão<br><br>";
        }
    }

    class Pix extends Pagamento {
        public function processar() {
            return "Pagamento processado com Pix<br><br>";
        }
    }

    class Boleto extends Pagamento {
        public function processar() {
            return "Pagamento processado com Boleto<br><br>";
        }
    }

    $pagamentos = [
        new Cartao(),
        new Pix(),
        new Boleto()
    ];

    foreach ($pagamentos as $p) {
        echo $p->processar() . "\n";
    }
?>