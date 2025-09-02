<?php
class Config {
    protected array $parametros = [];
}

class ConfigSistema extends Config {
    public function setParametro(string $chave, mixed $valor): void {
        $this->parametros[$chave] = $valor;
    }

    public function getParametro(string $chave): mixed {
        return $this->parametros[$chave] ?? null;
    }

    public function exibirParametros(): void {
        if (empty($this->parametros)) {
            echo "Nenhum parâmetro configurado.<br>";
            return;
        }

        echo "Parâmetros de configuração:<br>";
        foreach ($this->parametros as $chave => $valor) {
            echo "$chave: " . htmlspecialchars((string) $valor) . "<br>";
        }
    }
}

$config = new ConfigSistema();

$config->setParametro("modo_debug", true);
$config->setParametro("idioma", "pt-BR");
$config->setParametro("timezone", "America/Sao_Paulo");
$config->setParametro("versao", 1.5);

$config->exibirParametros();
?>
