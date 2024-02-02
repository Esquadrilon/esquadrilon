CREATE TABLE estados 
( 
    id INT NOT NULL AUTO_INCREMENT,
    codigoUf INT NOT NULL,
    nome VARCHAR (50) NOT NULL,
    uf CHAR (2) NOT NULL,
    regiao INT NOT NULL,
    PRIMARY KEY (Id)
);

CREATE TABLE cidades 
( 
    id INT NOT NULL AUTO_INCREMENT,
    codigo INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    uf CHAR(2) NOT NULL,
    PRIMARY KEY (Id)
);

CREATE TABLE clientes 
(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(75) NOT NULL,
    email VARCHAR(100) NULL,
    telefone VARCHAR(20) NULL,
    cpf_cnpj VARCHAR(18) NULL,
    endereco VARCHAR(200) NULL,
    cidade_id INT NOT NULL,
    estado_id INT NOT NULL,
    cep VARCHAR(9) NULL,
    observacoes TEXT NULL,
    criado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2),
    atualizado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
    PRIMARY KEY (id),
    FOREIGN KEY (estado_id) REFERENCES estados (Id) ON DELETE RESTRICT ON UPDATE NO ACTION,
    FOREIGN KEY (cidade_id) REFERENCES cidades (Id) ON DELETE RESTRICT ON UPDATE NO ACTION
);

CREATE TABLE obras 
(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(75) NOT NULL,
    situacao VARCHAR(100) NULL,
    website VARCHAR(255) NULL,
    endereco VARCHAR(200) NULL,
    cidade_id INT NOT NULL,
    estado_id INT NOT NULL,
    cep VARCHAR(9) NULL,
    cliente_id INT NOT NULL,
    observacoes TEXT NULL,
    criado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2),
    atualizado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
    PRIMARY KEY (id),
    FOREIGN KEY (estado_id) REFERENCES estados (id) ON DELETE RESTRICT ON UPDATE NO ACTION,
    FOREIGN KEY (cidade_id) REFERENCES cidades (id) ON DELETE RESTRICT ON UPDATE NO ACTION,
    FOREIGN KEY (cliente_id) REFERENCES clientes (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE perfis
(
    codigo VARCHAR(20) NOT NULL,
    descricao TEXT NULL,
    nativo VARCHAR(50) NULL,
    peso DOUBLE NOT NULL,
    linha VARCHAR(50) NULL,
    referencia VARCHAR(50) NULL,
    PRIMARY KEY (codigo)
);

CREATE TABLE cores
(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    codigo VARCHAR(50) NULL, 
    PRIMARY KEY (id)
);

CREATE TABLE entradas 
(
    id INT NOT NULL AUTO_INCREMENT,
    obra_id INT NOT NULL,
    perfil_codigo VARCHAR(20) NOT NULL,
    cor_id INT NOT NULL,
    tamanho INT NOT NULL,
    quantidade INT NOT NULL,
    nota VARCHAR(25) NULL,
    origem VARCHAR(50) NULL,
    destino VARCHAR(50) NULL,
    caminhao VARCHAR(10) NULL,
    motorista VARCHAR(75) NULL,
    responsavel VARCHAR(75) NOT NULL,
    observacoes TEXT NULL,
    criado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2),
    atualizado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
    PRIMARY KEY (id),
    FOREIGN KEY (obra_id) REFERENCES obras (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (perfil_codigo) REFERENCES perfis (codigo) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (cor_id) REFERENCES cores (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE saidas 
(
    id INT NOT NULL AUTO_INCREMENT,
    obra_id INT NOT NULL,
    perfil_codigo VARCHAR(20) NOT NULL,
    cor_id INT NOT NULL,
    tamanho INT NOT NULL,
    quantidade INT NOT NULL,
    romaneio VARCHAR(25) NULL,
    origem VARCHAR(50) NULL,
    destino VARCHAR(50) NULL,
    caminhao VARCHAR(10) NULL,
    motorista VARCHAR(75) NULL,
    responsavel VARCHAR(75) NOT NULL,
    observacoes TEXT NULL,
    criado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2),
    atualizado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
    PRIMARY KEY (id),
    FOREIGN KEY (obra_id) REFERENCES obras (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (perfil_codigo) REFERENCES perfis (codigo) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (cor_id) REFERENCES cores (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE INDEX idx_codigo ON perfis (codigo);

CREATE TABLE reservas
(
    id INT NOT NULL AUTO_INCREMENT,
    observacoes TEXT NULL,
    criado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2),
    atualizado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
    PRIMARY KEY (id)
);

CREATE TABLE itens_reserva
(
    id INT NOT NULL AUTO_INCREMENT,
    reserva_id INT NOT NULL,
    obra_id INT NOT NULL,
    perfil_codigo VARCHAR(20) NOT NULL,
    cor_id INT NOT NULL,
    tamanho INT NOT NULL,
    quantidade INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (reserva_id) REFERENCES reservas (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (obra_id) REFERENCES obras (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (perfil_codigo) REFERENCES perfis (codigo) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (cor_id) REFERENCES cores (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE processos 
(
    id INT NOT NULL,
    obra_id INT NOT NULL,
    tipologia VARCHAR(150) NOT NULL,
    tipo VARCHAR(150) NOT NULL,
    lote VARCHAR(150) NULL,
    lugar VARCHAR(150) NULL,
    pecas INT NOT NULL,
    pecas_feitas INT NULL,
    peso DOUBLE NOT NULL,
    situacao VARCHAR(100) NULL,
    observacoes TEXT NULL,
    previsto DATE NOT NULL,
    criado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2),
    atualizado TIMESTAMP(2) DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
    PRIMARY KEY (id),
    FOREIGN KEY (obra_id) REFERENCES obras (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE datas_processo
(
    processo_id INT NOT NULL,
    perfil DATE NULL,
    componente DATE NULL,
    esteira DATE NULL,
    vidro DATE NULL,
    corte DATE NULL,
    usinagem DATE NULL,
    montagem DATE NULL,
    PRIMARY KEY (processo_id),
    FOREIGN KEY (processo_id) REFERENCES processos (id) ON DELETE RESTRICT ON UPDATE CASCADE
);
