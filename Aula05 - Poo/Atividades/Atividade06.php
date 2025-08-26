<?php
    class Config {
        protected array $parametros = [];

        public function __construct(array $parametros = []) {
            $this->parametros = $parametros;
        }
    }
    class ConfigApp extends Config {
        public function getParametro(string $chave): mixed {
            return $this->parametros[$chave] ?? null;
        }

        public function setParametro(string $chave, mixed $valor): void {
            $this->parametros[$chave] = $valor;
        }

        public function exibirParametros(): void {
            echo "<pre>";
            print_r($this->parametros);
            echo "</pre>";
        }
    }
    class ConfigSistema extends Config {
        public function atualizarParametros(array $novosParametros): void {
            foreach ($novosParametros as $chave => $valor) {
                $this->parametros[$chave] = $valor;
            }
        }

        public function getTodosParametros(): array {
            return $this->parametros;
        }
    }
    $configApp = new ConfigApp(['tema' => 'escuro', 'idioma' => 'pt']);
    $configApp->setParametro('idioma', 'en');
    $configApp->setParametro('modo', 'desenvolvedor');
    $configApp->exibirParametros();

    $configSistema = new ConfigSistema();
    echo "Atualizando parâmetro:<br>";
    $configSistema->atualizarParametros(['cache' => true, 'debug' => false]);
    print_r($configSistema->getTodosParametros());

?>