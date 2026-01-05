-- Tabela de províncias (opcional, para padronização)
CREATE TABLE provincias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'medico', 'paciente') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de especialidades médicas
CREATE TABLE especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela de médicos
CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    especialidade_id INT,
    numero_ordem VARCHAR(50) NOT NULL, -- Ordem dos Médicos de Angola
    nivel ENUM('Generalista', 'Especialista', 'Interno') NOT NULL,
    hospital VARCHAR(100),
    provincia_id INT,
    telefone VARCHAR(30),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (especialidade_id) REFERENCES especialidades(id),
    FOREIGN KEY (provincia_id) REFERENCES provincias(id)
);

-- Tabela de pacientes
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_nascimento DATE,
    sexo ENUM('masculino', 'feminino', 'outro'),
    telefone VARCHAR(30),
    endereco TEXT,
    provincia_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (provincia_id) REFERENCES provincias(id)
);

-- Tabela de doenças respiratórias
CREATE TABLE doencas_respiratorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

-- Tabela de diagnósticos
CREATE TABLE diagnosticos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    doenca_id INT NOT NULL,
    data_diagnostico DATE NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id),
    FOREIGN KEY (doenca_id) REFERENCES doencas_respiratorias(id)
);

-- Tabela de tratamentos
CREATE TABLE tratamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    diagnostico_id INT NOT NULL,
    descricao TEXT NOT NULL,
    data_inicio DATE,
    data_fim DATE,
    FOREIGN KEY (diagnostico_id) REFERENCES diagnosticos(id)
);

-- Tabela de consultas médicas
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    data_consulta DATETIME NOT NULL,
    motivo TEXT,
    observacoes TEXT,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
);

-- Tabela de exames
CREATE TABLE exames (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    tipo VARCHAR(100),
    resultado TEXT,
    data_exame DATE,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
);
