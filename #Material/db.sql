-- Active: 1752038978491@@127.0.0.1@3306@db_sgh

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil_id INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (perfil_id) REFERENCES perfis(id)
);


CREATE TABLE perfis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE -- Médico, Enfermeiro, Administrador
);

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    data_nascimento DATE,
    sexo ENUM('M', 'F', 'Outro'),
    endereco TEXT,
    telefone VARCHAR(20),
    criado_por INT, -- quem registrou o paciente
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (criado_por) REFERENCES usuarios(id)
);


CREATE TABLE historicos_clinicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    descricao TEXT NOT NULL,
    data_registro DATE NOT NULL,
    registrado_por INT NOT NULL, -- médico ou enfermeiro
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (registrado_por) REFERENCES usuarios(id)
);


CREATE TABLE estados_clinicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    estado_atual TEXT NOT NULL,
    atualizado_por INT NOT NULL, -- enfermeiro
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (atualizado_por) REFERENCES usuarios(id)
);

CREATE TABLE acessos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_login VARCHAR(45),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

