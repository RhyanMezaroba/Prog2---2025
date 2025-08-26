<?php
    class ConexaoBD {
        private ?PDO $conexao = null;

        private function conectar(): void {
            $host = 'localhost';
            $dbname = 'meu_banco';
            $usuario = 'root';
            $senha = '';

            try {
                $this->conexao = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
                $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        public function getConexao(): PDO {
            if ($this->conexao === null) {
                $this->conectar();
            }
            return $this->conexao;
        }
    }
    $conexaoBD = new ConexaoBD();
    $conexao = $conexaoBD->getConexao();

    $stmt = $conexao->query("SELECT NOW()");
    echo "Conexão realizada com sucesso: " . $stmt->fetchColumn();
?>
