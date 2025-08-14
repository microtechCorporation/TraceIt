CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  token_api VARCHAR(255) UNIQUE,         -- Token para autenticação via API
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ativo BOOLEAN DEFAULT TRUE             --Para ativar/desativar usuários facilmente
);

CREATE TABLE logs_usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  acao VARCHAR(255) NOT NULL,
  descricao TEXT,
  ip_origem VARCHAR(45),                 -- para IPv4 e IPv6
  user_agent VARCHAR(255),               -- navegador/aplicativo usado
  data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ativo BOOLEAN DEFAULT TRUE
);
CREATE TABLE logs_admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  admin_id INT NOT NULL,
  acao VARCHAR(255) NOT NULL,
  descricao TEXT,
  ip_origem VARCHAR(45),
  user_agent VARCHAR(255),
  data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (admin_id) REFERENCES admins(id)
);

CREATE TABLE dispositivos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  imei VARCHAR(20) NOT NULL UNIQUE,
  marca VARCHAR(100) NOT NULL,
  modelo VARCHAR(100) NOT NULL,
  cor VARCHAR(50),
  fotos TEXT,              -- pode guardar URLs separados por vírgula ou JSON
  observacoes TEXT,
  status ENUM('ativo', 'roubado', 'perdido', 'recuperado') DEFAULT 'ativo',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
CREATE TABLE ocorrencias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dispositivo_id INT NOT NULL,
  usuario_id INT NOT NULL,
  tipo VARCHAR(50) NOT NULL,             -- Ex: 'furto', 'perda', 'extravio', 'outro'
  data_ocorrencia DATE NOT NULL,
  local VARCHAR(255) NOT NULL,
  descricao TEXT,
  status VARCHAR(50) DEFAULT 'registrado',  -- Ex: 'registrado', 'recuperado', 'cancelado'
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (dispositivo_id) REFERENCES dispositivos(id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);





