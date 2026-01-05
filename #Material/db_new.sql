-- ====================================
-- TABELAS BÁSICAS DE REFERÊNCIA
-- ====================================

CREATE TABLE provincias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE especialidades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

CREATE TABLE doencas_respiratorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT
);

-- ====================================
-- TABELAS DE PESSOAS E PERFIS
-- ====================================

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    perfil ENUM('admin','superadmin','medico','enfermeiro', 'enfermeiro_chefe','recepcionista') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE medicos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    especialidade_id INT NOT NULL,
    numero_registro VARCHAR(50) UNIQUE NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (especialidade_id) REFERENCES especialidades(id)
);

CREATE TABLE pacientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    data_nascimento DATE,
    genero ENUM('M','F'),
    provincia_id INT,
    contato VARCHAR(20),
    FOREIGN KEY (provincia_id) REFERENCES provincias(id)
);

-- ====================================
-- TABELAS DE PROCESSOS MÉDICOS
-- ====================================

CREATE TABLE consultas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    data_consulta DATETIME NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
);

CREATE TABLE diagnosticos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    consulta_id INT NOT NULL,
    doenca_id INT NOT NULL,
    descricao TEXT,
    FOREIGN KEY (consulta_id) REFERENCES consultas(id),
    FOREIGN KEY (doenca_id) REFERENCES doencas_respiratorias(id)
);

CREATE TABLE exames (
    id INT PRIMARY KEY AUTO_INCREMENT,
    consulta_id INT NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    resultado TEXT,
    data_exame DATE,
    FOREIGN KEY (consulta_id) REFERENCES consultas(id)
);

CREATE TABLE tratamentos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    diagnostico_id INT NOT NULL,
    descricao TEXT NOT NULL,
    duracao_dias INT,
    FOREIGN KEY (diagnostico_id) REFERENCES diagnosticos(id)
);

-- ====================================
-- TABELAS COMPLEMENTARES PARA GESTÃO
-- ====================================

CREATE TABLE internamentos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    paciente_id INT NOT NULL,
    data_internamento DATE NOT NULL,
    data_alta DATE,
    motivo TEXT,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);

CREATE TABLE leitos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero VARCHAR(10) NOT NULL,
    status ENUM('ocupado','livre','manutencao') DEFAULT 'livre'
);

CREATE TABLE ocupacao_leitos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    leito_id INT NOT NULL,
    internamento_id INT NOT NULL,
    FOREIGN KEY (leito_id) REFERENCES leitos(id),
    FOREIGN KEY (internamento_id) REFERENCES internamentos(id)
);
