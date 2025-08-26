<?php
    class Carro {
        private string $marca;
        private string $modelo;
        private int $ano;

        function __construct(string $marca, string $modelo, int $ano) {
            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->ano = $ano;
        }

        function infCarro() {
            echo "O seu carro é da marca {$this->marca}, modelo {$this->modelo} e é do ano {$this->ano} baseado na fabricação!";
        }
    }

    $c1 = new Carro("Renaut", "Logan", 2017);
    $c1->infCarro();

    echo "<br>";
    echo "<br>";

    $c2 = new Carro("Koenigsegg", "Agera", 2000);
    $c2->infCarro();

    echo "<br>";
    echo "<br>";

    $c3 = new Carro("Fiat", "Punto", 2023);
    $c3->infCarro();
    
    echo "<br>";
    echo "<br>";
?>
