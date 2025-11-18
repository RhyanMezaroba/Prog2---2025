CREATE DATABASE DoaSys_BD CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE DoaSys_BD;

-- Usuários
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE,
  senha VARCHAR(255) NOT NULL,
  tipo ENUM('cliente','instituicao','anonimo','admin') NOT NULL DEFAULT 'anonimo',
  documento VARCHAR(30) DEFAULT NULL, -- CPF ou CNPJ
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Doações
CREATE TABLE doacoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NULL,
  beneficiario_nome VARCHAR(150),
  beneficiario_cpf VARCHAR(20),
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT,
  categoria VARCHAR(100),
  quantidade INT DEFAULT NULL,
  valor DECIMAL(10,2) DEFAULT NULL,
  cidade VARCHAR(100),
  bairro VARCHAR(100),
  endereco VARCHAR(255),
  cep VARCHAR(9),
  status ENUM('pendente','em_andamento','concluida','cancelada') DEFAULT 'pendente',
  data_doacao DATE DEFAULT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);
