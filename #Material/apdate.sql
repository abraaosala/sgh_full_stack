-- ========================================
-- 1. USUÁRIOS (base para todos os perfis)
-- ========================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    genero ENUM('M','F','O') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    senha_gerada TINYINT DEFAULT NULL,
    perfil ENUM('superadmin','admin','medico','paciente','enfermeiro','secretario') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================================
-- 2. MÉDICOS
-- ========================================
CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    especialidade_id INT DEFAULT NULL,
    numero_ordem VARCHAR(50) NOT NULL,
    nivel ENUM('Generalista','Especialista','Interno') NOT NULL,
    hospital VARCHAR(100),
    provincia_id INT,
    telefone VARCHAR(30),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    -- FOREIGN KEY (especialidade_id) REFERENCES especialidades(id)
    -- FOREIGN KEY (provincia_id) REFERENCES provincias(id)
);

-- ========================================
-- 3. PACIENTES
-- (removido medico_id fixo)
-- ========================================
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(30),
    endereco TEXT,
    provincia_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    -- FOREIGN KEY (provincia_id) REFERENCES provincias(id)
);

-- ========================================
-- 4. VÍNCULO MÉDICO ↔ PACIENTE (opcional)
-- ========================================
CREATE TABLE medico_paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    paciente_id INT NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE DEFAULT NULL,
    FOREIGN KEY (medico_id) REFERENCES medicos(id),
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);

-- ========================================
-- 5. AGENDAS (disponibilidade médica)
-- ========================================
CREATE TABLE agendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    title VARCHAR(244) NOT NULL,
    color VARCHAR(100),
    start DATETIME NOT NULL,
    end DATETIME,
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
);

-- ========================================
-- 6. CONSULTAS (marcação do paciente em um slot da agenda)
-- ========================================
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    agenda_id INT NULL, -- consulta ocupa um horário da agenda
    motivo TEXT,
    observacoes TEXT,
    status ENUM('C','R','F') NOT NULL DEFAULT 'C', -- Confirmada, Realizada, Cancelada
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id),
    FOREIGN KEY (agenda_id) REFERENCES agendas(id)
);

-- ========================================
-- 7. DIAGNÓSTICOS
-- ========================================
CREATE TABLE diagnosticos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    doenca_id INT NOT NULL,
    data_diagnostico DATE NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
    -- FOREIGN KEY (doenca_id) REFERENCES doencas_respiratorias(id)
);

-- ========================================
-- 8. TRATAMENTOS (ligado a diagnóstico)
-- ========================================
CREATE TABLE tratamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    diagnostico_id INT NOT NULL,
    descricao TEXT NOT NULL,
    data_inicio DATE,
    data_fim DATE,
    FOREIGN KEY (diagnostico_id) REFERENCES diagnosticos(id)
);

-- ========================================
-- 9. EXAMES
-- ========================================
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
