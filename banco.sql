-- Solutec Segurança Eletrônica — banco de dados
CREATE DATABASE IF NOT EXISTS solutec_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE solutec_db;

CREATE TABLE IF NOT EXISTS produtos (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    nome        VARCHAR(100) NOT NULL,
    descricao   TEXT,
    preco       DECIMAL(10,2) NOT NULL,
    categoria   ENUM('Câmeras','Alarmes','Controle de Acesso','Monitoramento') NOT NULL,
    imagem_url  VARCHAR(255),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS clientes (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    nome        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL,
    telefone    VARCHAR(20),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pedidos (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id  INT NOT NULL,
    data_pedido DATE NOT NULL,
    status      ENUM('Pendente','Confirmado','Cancelado') DEFAULT 'Pendente',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

CREATE TABLE IF NOT EXISTS pedido_produtos (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id   INT NOT NULL,
    produto_id  INT NOT NULL,
    quantidade  INT DEFAULT 1,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- Seed: produtos
INSERT INTO produtos (nome, descricao, preco, categoria, imagem_url) VALUES
('Câmera IP Externa HD',      'Câmera externa com resolução HD e visão noturna.',          299.90, 'Câmeras',            'https://placehold.co/400x300/1a1a2e/00ff88?text=Camera+IP+Externa+HD'),
('Câmera Dome Interna',       'Câmera dome discreta para ambientes internos.',              189.90, 'Câmeras',            'https://placehold.co/400x300/1a1a2e/00ff88?text=Camera+Dome+Interna'),
('Kit 4 Câmeras + DVR',       'Kit completo com 4 câmeras coloridas e DVR 4 canais.',      899.00, 'Câmeras',            'https://placehold.co/400x300/1a1a2e/00ff88?text=Kit+4+Cameras+DVR'),
('Câmera 360° WiFi',          'Câmera panorâmica WiFi com rotação automática.',             349.90, 'Câmeras',            'https://placehold.co/400x300/1a1a2e/00ff88?text=Camera+360+WiFi'),
('Alarme Residencial Completo','Kit de alarme com central, sirene e 4 sensores.',           459.00, 'Alarmes',            'https://placehold.co/400x300/1a1a2e/00ff88?text=Alarme+Residencial'),
('Sensor de Presença',        'Sensor infravermelho passivo para detecção de movimento.',    89.90, 'Alarmes',            'https://placehold.co/400x300/1a1a2e/00ff88?text=Sensor+de+Presenca'),
('Controle de Acesso Biométrico','Leitor biométrico de impressão digital com teclado.',     599.00, 'Controle de Acesso', 'https://placehold.co/400x300/1a1a2e/00ff88?text=Controle+Biometrico'),
('Central de Monitoramento',  'Software de monitoramento remoto com gravação em nuvem.',  1299.00, 'Monitoramento',      'https://placehold.co/400x300/1a1a2e/00ff88?text=Central+Monitoramento');

-- Seed: clientes
INSERT INTO clientes (nome, email, telefone) VALUES
('João Silva',    'joao.silva@email.com',    '(11) 99999-1111'),
('Maria Souza',   'maria.souza@email.com',   '(21) 98888-2222'),
('Carlos Oliveira','carlos.oliveira@email.com','(31) 97777-3333');

-- Seed: pedidos
INSERT INTO pedidos (cliente_id, data_pedido, status) VALUES
(1, '2026-06-01', 'Confirmado'),
(2, '2026-06-03', 'Pendente');

-- Seed: pivot pedido_produtos
INSERT INTO pedido_produtos (pedido_id, produto_id, quantidade) VALUES
(1, 1, 2),
(1, 5, 1),
(2, 7, 1),
(2, 8, 1);
