
-- A despejar estrutura para tabela sgh.agendas
CREATE TABLE IF NOT EXISTS `agendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medico_id` int NOT NULL,
  `title` varchar(244) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_medico` (`medico_id`) USING BTREE,
  KEY `idx_start` (`start`) USING BTREE,
  CONSTRAINT `agendas_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Armazena Agenda Médica';

-- A despejar dados para tabela sgh.agendas: ~61 rows (aproximadamente)
DELETE FROM `agendas`;
INSERT INTO `agendas` (`id`, `medico_id`, `title`, `color`, `start`, `end`, `create_time`) VALUES
	(31, 1, 'Turno Matinal', '#36b9cc', '2025-10-01 08:00:00', '2025-10-01 12:00:00', '2025-09-23 07:35:12'),
	(32, 2, 'Turno Vespertino', '#f6c23e', '2025-09-29 13:00:00', '2025-09-29 18:00:00', '2025-09-23 07:35:12'),
	(33, 1, 'Turno Vespertino', '#f6c23e', '2025-10-20 13:00:00', '2025-10-20 18:00:00', '2025-09-23 07:35:12'),
	(34, 1, 'Turno Noturno', '#4e73df', '2025-10-16 19:00:00', '2025-10-16 23:00:00', '2025-09-23 07:35:12'),
	(35, 2, 'Turno Matinal', '#36b9cc', '2025-09-24 08:00:00', '2025-09-24 12:00:00', '2025-09-23 07:35:12'),
	(36, 2, 'Turno Noturno', '#4e73df', '2025-09-27 19:00:00', '2025-09-27 23:00:00', '2025-09-23 07:35:13'),
	(37, 2, 'Turno Vespertino', '#f6c23e', '2025-10-23 13:00:00', '2025-10-23 18:00:00', '2025-09-23 07:35:13'),
	(38, 2, 'Turno Vespertino', '#f6c23e', '2025-10-20 13:00:00', '2025-10-20 18:00:00', '2025-09-23 07:35:13'),
	(39, 2, 'Turno Matinal', '#36b9cc', '2025-09-26 08:00:00', '2025-09-26 12:00:00', '2025-09-23 07:35:13'),
	(40, 2, 'Turno Noturno', '#4e73df', '2025-10-07 19:00:00', '2025-10-07 23:00:00', '2025-09-23 07:35:13'),
	(41, 2, 'Turno Noturno', '#4e73df', '2025-10-05 19:00:00', '2025-10-05 23:00:00', '2025-09-23 07:35:13'),
	(42, 1, 'Turno Matinal', '#36b9cc', '2025-10-09 08:00:00', '2025-10-09 12:00:00', '2025-09-23 07:35:13'),
	(43, 2, 'Turno Noturno', '#4e73df', '2025-10-12 19:00:00', '2025-10-12 23:00:00', '2025-09-23 07:35:13'),
	(44, 2, 'Turno Noturno', '#4e73df', '2025-10-15 19:00:00', '2025-10-15 23:00:00', '2025-09-23 07:35:13'),
	(45, 1, 'Turno Vespertino', '#f6c23e', '2025-10-07 13:00:00', '2025-10-07 18:00:00', '2025-09-23 07:35:13'),
	(46, 1, 'Turno Matinal', '#36b9cc', '2025-10-04 08:00:00', '2025-10-04 12:00:00', '2025-09-23 07:35:13'),
	(47, 1, 'Turno Matinal', '#36b9cc', '2025-10-15 08:00:00', '2025-10-15 12:00:00', '2025-09-23 07:35:13'),
	(48, 1, 'Turno Noturno', '#4e73df', '2025-10-21 19:00:00', '2025-10-21 23:00:00', '2025-09-23 07:35:13'),
	(51, 1, 'Turno Noturno', '#4e73df', '2025-09-29 19:00:00', '2025-09-29 23:00:00', '2025-09-23 07:35:13'),
	(52, 2, 'Turno Vespertino', '#f6c23e', '2025-10-13 13:00:00', '2025-10-13 18:00:00', '2025-09-23 07:35:13'),
	(53, 1, 'Turno Matinal', '#36b9cc', '2025-10-12 08:00:00', '2025-10-12 12:00:00', '2025-09-23 07:35:13'),
	(54, 2, 'Turno Matinal', '#36b9cc', '2025-10-09 08:00:00', '2025-10-09 12:00:00', '2025-09-23 07:35:13'),
	(55, 1, 'Turno Matinal', '#36b9cc', '2025-10-03 08:00:00', '2025-10-03 12:00:00', '2025-09-23 07:35:13'),
	(56, 2, 'Turno Vespertino', '#f6c23e', '2025-10-16 13:00:00', '2025-10-16 18:00:00', '2025-09-23 07:35:13'),
	(57, 1, 'Turno Matinal', '#36b9cc', '2025-09-23 08:00:00', '2025-09-23 12:00:00', '2025-09-23 07:35:13'),
	(58, 1, 'Turno Noturno', '#4e73df', '2025-09-24 19:00:00', '2025-09-24 23:00:00', '2025-09-23 07:35:13'),
	(59, 1, 'Turno Matinal', '#36b9cc', '2025-09-27 08:00:00', '2025-09-27 12:00:00', '2025-09-23 07:35:13'),
	(60, 1, 'Turno Vespertino', '#f6c23e', '2025-09-26 13:00:00', '2025-09-26 18:00:00', '2025-09-23 07:35:13'),
	(61, 2, 'Turno Vespertino', '#6f42c1', '2025-10-15 11:00:00', '2025-10-15 17:00:00', '2025-09-30 08:01:52'),
	(62, 3, 'Turno Matinal', '#6f42c1', '2025-09-18 05:00:00', '2025-09-18 11:00:00', '2025-09-30 08:03:37'),
	(63, 2, 'Turno  Matinal', '#ffc107', '2025-12-02 07:00:00', '2025-12-02 13:00:00', '2025-12-29 09:14:42'),
	(72, 4, 'Turno Noturno', '#4e73df', '2026-01-25 19:00:00', '2026-01-25 23:00:00', '2026-01-19 14:50:52'),
	(73, 4, 'Turno Noturno', '#4e73df', '2026-02-17 19:00:00', '2026-02-17 23:00:00', '2026-01-19 14:50:52'),
	(74, 4, 'Turno Noturno', '#4e73df', '2026-01-28 19:00:00', '2026-01-28 23:00:00', '2026-01-19 14:50:53'),
	(75, 4, 'Turno Matinal', '#36b9cc', '2026-01-26 08:00:00', '2026-01-26 12:00:00', '2026-01-19 14:50:53'),
	(76, 3, 'Turno Noturno', '#4e73df', '2026-01-19 19:00:00', '2026-01-19 23:00:00', '2026-01-19 14:50:53'),
	(77, 2, 'Turno Vespertino', '#f6c23e', '2026-01-24 13:00:00', '2026-01-24 18:00:00', '2026-01-19 14:50:53'),
	(78, 4, 'Turno Matinal', '#36b9cc', '2026-01-25 08:00:00', '2026-01-25 12:00:00', '2026-01-19 14:50:53'),
	(79, 5, 'Turno Vespertino', '#f6c23e', '2026-02-04 13:00:00', '2026-02-04 18:00:00', '2026-01-19 14:50:53'),
	(80, 1, 'Turno Noturno', '#4e73df', '2026-02-11 19:00:00', '2026-02-11 23:00:00', '2026-01-19 14:50:53'),
	(81, 5, 'Turno Noturno', '#4e73df', '2026-01-24 19:00:00', '2026-01-24 23:00:00', '2026-01-19 14:50:53'),
	(82, 3, 'Turno Noturno', '#4e73df', '2026-02-03 19:00:00', '2026-02-03 23:00:00', '2026-01-19 14:50:53'),
	(83, 2, 'Turno Matinal', '#36b9cc', '2026-02-05 08:00:00', '2026-02-05 12:00:00', '2026-01-19 14:50:53'),
	(84, 4, 'Turno Vespertino', '#f6c23e', '2026-02-11 13:00:00', '2026-02-11 18:00:00', '2026-01-19 14:50:53'),
	(85, 5, 'Turno Matinal', '#36b9cc', '2026-01-25 08:00:00', '2026-01-25 12:00:00', '2026-01-19 14:50:53'),
	(86, 2, 'Turno Noturno', '#4e73df', '2026-02-02 19:00:00', '2026-02-02 23:00:00', '2026-01-19 14:50:53'),
	(87, 5, 'Turno Noturno', '#4e73df', '2026-02-13 19:00:00', '2026-02-13 23:00:00', '2026-01-19 14:50:53'),
	(88, 3, 'Turno Matinal', '#36b9cc', '2026-02-09 08:00:00', '2026-02-09 12:00:00', '2026-01-19 14:50:53'),
	(89, 4, 'Turno Vespertino', '#f6c23e', '2026-02-02 13:00:00', '2026-02-02 18:00:00', '2026-01-19 14:50:53'),
	(90, 2, 'Turno Vespertino', '#f6c23e', '2026-02-04 13:00:00', '2026-02-04 18:00:00', '2026-01-19 14:50:53'),
	(91, 1, 'Turno Noturno', '#4e73df', '2026-02-12 19:00:00', '2026-02-12 23:00:00', '2026-01-19 14:50:53'),
	(92, 2, 'Turno Matinal', '#36b9cc', '2026-02-17 08:00:00', '2026-02-17 12:00:00', '2026-01-19 14:50:53'),
	(93, 3, 'Turno Matinal', '#36b9cc', '2026-01-30 07:00:00', '2026-01-30 11:00:00', '2026-01-19 14:50:53'),
	(94, 5, 'Turno Vespertino', '#f6c23e', '2026-02-13 13:00:00', '2026-02-13 18:00:00', '2026-01-19 14:50:53'),
	(95, 1, 'Turno Noturno', '#4e73df', '2026-01-31 19:00:00', '2026-01-31 23:00:00', '2026-01-19 14:50:53'),
	(96, 1, 'Turno Vespertino', '#f6c23e', '2026-02-07 13:00:00', '2026-02-07 18:00:00', '2026-01-19 14:50:54'),
	(97, 3, 'Turno Vespertino', '#f6c23e', '2026-02-17 13:00:00', '2026-02-17 18:00:00', '2026-01-19 14:50:54'),
	(98, 4, 'Turno Noturno', '#4e73df', '2026-01-25 19:00:00', '2026-01-25 23:00:00', '2026-01-19 14:50:54'),
	(99, 3, 'Turno Matinal', '#36b9cc', '2026-02-14 08:00:00', '2026-02-14 12:00:00', '2026-01-19 14:50:54'),
	(100, 5, 'Turno Matinal', '#36b9cc', '2026-01-31 08:00:00', '2026-01-31 12:00:00', '2026-01-19 14:50:54'),
	(101, 2, 'Turno Matinal', '#36b9cc', '2026-02-14 08:00:00', '2026-02-14 12:00:00', '2026-01-19 14:50:54');

-- A despejar estrutura para tabela sgh.consultas
CREATE TABLE IF NOT EXISTS `consultas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paciente_id` int NOT NULL,
  `medico_id` int NOT NULL,
  `agenda_id` int DEFAULT NULL,
  `marcacao` datetime NOT NULL,
  `motivo` text,
  `observacao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status` enum('Agendada','Realizada','Cancelada') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Agendada',
  `criado_em` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `marcacao` (`marcacao`),
  KEY `paciente_id` (`paciente_id`),
  KEY `medico_id` (`medico_id`),
  KEY `agenda_id` (`agenda_id`),
  CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`),
  CONSTRAINT `consultas_ibfk_3` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.consultas: ~0 rows (aproximadamente)
DELETE FROM `consultas`;
INSERT INTO `consultas` (`id`, `paciente_id`, `medico_id`, `agenda_id`, `marcacao`, `motivo`, `observacao`, `status`, `criado_em`) VALUES
	(2, 2, 2, NULL, '2026-01-14 10:00:00', NULL, '', 'Agendada', '2026-01-07 22:56:56');

-- A despejar estrutura para tabela sgh.diagnosticos
CREATE TABLE IF NOT EXISTS `diagnosticos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paciente_id` int NOT NULL,
  `medico_id` int NOT NULL,
  `doenca_id` int NOT NULL,
  `data_diagnostico` date NOT NULL,
  `observacoes` text,
  PRIMARY KEY (`id`),
  KEY `paciente_id` (`paciente_id`),
  KEY `medico_id` (`medico_id`),
  KEY `doenca_id` (`doenca_id`),
  CONSTRAINT `diagnosticos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  CONSTRAINT `diagnosticos_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`),
  CONSTRAINT `diagnosticos_ibfk_3` FOREIGN KEY (`doenca_id`) REFERENCES `doencas_respiratorias` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.diagnosticos: ~0 rows (aproximadamente)
DELETE FROM `diagnosticos`;

-- A despejar estrutura para tabela sgh.doencas_respiratorias
CREATE TABLE IF NOT EXISTS `doencas_respiratorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.doencas_respiratorias: ~15 rows (aproximadamente)
DELETE FROM `doencas_respiratorias`;
INSERT INTO `doencas_respiratorias` (`id`, `nome`, `descricao`, `icon`) VALUES
	(1, 'Asma', 'Inflamação crônica das vias respiratórias, que causa dificuldade para respirar, chiado, tosse e aperto no peito.', 'lungs'),
	(2, 'Bronquite', 'Inflamação dos brônquios, geralmente causada por infecção viral ou exposição a irritantes como fumaça.', 'lungs'),
	(3, 'Pneumonia', 'Infecção dos pulmões que pode ser causada por bactérias, vírus ou fungos. Provoca febre, tosse e falta de ar.', 'lungs'),
	(4, 'Enfisema pulmonar', 'Doença pulmonar crônica que causa destruição dos alvéolos, dificultando a respiração.', 'lungs'),
	(5, 'Doença Pulmonar Obstrutiva Crônica (DPOC)', 'Conjunto de doenças pulmonares que bloqueiam o fluxo de ar, geralmente causada por tabagismo.', 'lungs'),
	(6, 'Tuberculose', 'Infecção bacteriana contagiosa que afeta principalmente os pulmões. Causa tosse prolongada, febre e emagrecimento.', 'lungs'),
	(7, 'Fibrose pulmonar', 'Formação de cicatrizes no tecido pulmonar, tornando a respiração difícil.', 'lungs'),
	(8, 'Rinite alérgica', 'Reação alérgica que provoca espirros, coriza, obstrução nasal e coceira.', 'sneeze'),
	(9, 'Sinusite', 'Inflamação dos seios da face, causando dor de cabeça, pressão facial e secreção nasal.', 'head'),
	(10, 'COVID-19', 'Doença respiratória causada pelo coronavírus SARS-CoV-2, com sintomas variando de leves a graves, incluindo febre, tosse e falta de ar.', 'virus'),
	(11, 'Gripe (Influenza)', 'Infecção viral respiratória aguda com febre, dor no corpo, tosse e fadiga.', 'virus'),
	(12, 'Resfriado comum', 'Infecção viral leve das vias aéreas superiores com coriza, espirros e garganta irritada.', 'snowflake'),
	(13, 'Apneia do sono', 'Distúrbio no qual a respiração para e recomeça durante o sono.', 'bed'),
	(14, 'Câncer de pulmão', 'Tumor maligno que se desenvolve nos pulmões, muitas vezes associado ao tabagismo.', 'ribbon'),
	(15, 'Sarcoidose pulmonar', 'Doença inflamatória que afeta diversos órgãos, incluindo os pulmões, com formação de granulomas.', 'lungs');

-- A despejar estrutura para tabela sgh.especialidades
CREATE TABLE IF NOT EXISTS `especialidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.especialidades: ~15 rows (aproximadamente)
DELETE FROM `especialidades`;
INSERT INTO `especialidades` (`id`, `nome`) VALUES
	(1, 'Pneumologia'),
	(2, 'Alergologia'),
	(3, 'Otorrinolaringologia'),
	(4, 'Infectologia'),
	(5, 'Medicina Intensiva'),
	(6, 'Medicina de Família'),
	(7, 'Clínica Médica'),
	(8, 'Pediatria'),
	(9, 'Imunologia Clínica'),
	(10, 'Radiologia'),
	(11, 'Fisioterapia Respiratória'),
	(12, 'Enfermagem em Terapia Intensiva'),
	(13, 'Cirurgia Torácica'),
	(14, 'Terapia Ocupacional Respiratória'),
	(15, 'Anestesiologia');

-- A despejar estrutura para tabela sgh.estados_clinicos
CREATE TABLE IF NOT EXISTS `estados_clinicos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paciente_id` int NOT NULL,
  `estado_atual` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.estados_clinicos: ~0 rows (aproximadamente)
DELETE FROM `estados_clinicos`;

-- A despejar estrutura para tabela sgh.exames
CREATE TABLE IF NOT EXISTS `exames` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paciente_id` int NOT NULL,
  `medico_id` int NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `resultado` text,
  `data_exame` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paciente_id` (`paciente_id`),
  KEY `medico_id` (`medico_id`),
  CONSTRAINT `exames_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  CONSTRAINT `exames_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.exames: ~0 rows (aproximadamente)
DELETE FROM `exames`;

-- A despejar estrutura para tabela sgh.funcionarios
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `numero_ordem` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nivel` enum('Generalista','Especialista','Interno') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hospital` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `provincia_id` int DEFAULT NULL,
  `telefone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_funcionarios_usuarios` (`usuario_id`),
  KEY `FK_funcionarios_provincias` (`provincia_id`),
  CONSTRAINT `FK_funcionarios_provincias` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_funcionarios_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.funcionarios: ~2 rows (aproximadamente)
DELETE FROM `funcionarios`;
INSERT INTO `funcionarios` (`id`, `usuario_id`, `numero_ordem`, `nivel`, `hospital`, `provincia_id`, `telefone`) VALUES
	(1, 3, '17540-5647', NULL, NULL, 1, NULL),
	(2, 8, 'GR-086745', NULL, NULL, 1, NULL);

-- A despejar estrutura para tabela sgh.historicos_clinicos
CREATE TABLE IF NOT EXISTS `historicos_clinicos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paciente_id` int NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_registro` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_historicos_clinicos_pacientes` (`paciente_id`),
  CONSTRAINT `FK_historicos_clinicos_pacientes` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.historicos_clinicos: ~0 rows (aproximadamente)
DELETE FROM `historicos_clinicos`;

-- A despejar estrutura para tabela sgh.leitos
CREATE TABLE IF NOT EXISTS `leitos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Disponível',
  `descricao` text COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- A despejar dados para tabela sgh.leitos: ~0 rows (aproximadamente)
DELETE FROM `leitos`;
INSERT INTO `leitos` (`id`, `numero`, `tipo`, `status`, `descricao`, `created_at`, `updated_at`) VALUES
	(2, '001-A', 'UTI Respiratória', 'Livre', '', '2026-01-08 08:21:50', '2026-01-08 08:22:54');

-- A despejar estrutura para tabela sgh.medicos
CREATE TABLE IF NOT EXISTS `medicos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `especialidade_id` int DEFAULT NULL,
  `numero_ordem` varchar(50) NOT NULL,
  `nivel` enum('Generalista','Especialista','Interno') NOT NULL,
  `hospital` varchar(100) DEFAULT NULL,
  `provincia_id` int DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `especialidade_id` (`especialidade_id`),
  KEY `provincia_id` (`provincia_id`),
  CONSTRAINT `medicos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `medicos_ibfk_2` FOREIGN KEY (`especialidade_id`) REFERENCES `especialidades` (`id`),
  CONSTRAINT `medicos_ibfk_3` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.medicos: ~5 rows (aproximadamente)
DELETE FROM `medicos`;
INSERT INTO `medicos` (`id`, `usuario_id`, `especialidade_id`, `numero_ordem`, `nivel`, `hospital`, `provincia_id`, `telefone`) VALUES
	(1, 4, 6, '2785-6789', 'Generalista', NULL, 11, '946245160'),
	(2, 7, 10, '3567', 'Especialista', NULL, 1, '929089966'),
	(3, 11, 15, '3977-9606', 'Generalista', NULL, 1, '946245160'),
	(4, 16, 2, '006567478', 'Generalista', 'Array', 2, '946245160'),
	(5, 17, 13, '097867', 'Especialista', 'SGH', 15, '946245160');

-- A despejar estrutura para tabela sgh.pacientes
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `endereco` text,
  `provincia_id` int DEFAULT NULL,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `usuario_id` (`usuario_id`),
  KEY `provincia_id` (`provincia_id`),
  CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `pacientes_ibfk_2` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.pacientes: ~6 rows (aproximadamente)
DELETE FROM `pacientes`;
INSERT INTO `pacientes` (`id`, `usuario_id`, `code`, `telefone`, `endereco`, `provincia_id`, `criado_em`) VALUES
	(2, 9, 'L3F5-1745', '924556721', '1º de Maio / Soyo', 1, '2025-09-27 08:10:39'),
	(3, 10, 'O4N6-5620', '932087276', 'Kitambi - Soyo', 1, '2025-09-27 08:14:59'),
	(4, 14, 'F7W9-0049', '929089966', 'Zango 8000', 6, '2025-12-17 01:50:10'),
	(5, 15, 'B3Q1-2557', '929089966', '1º de Maio / Soyo', 2, '2025-12-17 01:57:18'),
	(9, 22, 'Z8R4-3546', '940000000', 'DDDDDDDDDDDDDd', 16, '2026-02-01 09:12:46'),
	(10, 23, 'D9V2-5288', '90000000', 'hhhhhhhhhhhhhhhhhh', 18, '2026-02-01 09:17:49');

-- A despejar estrutura para tabela sgh.provincias
CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.provincias: ~21 rows (aproximadamente)
DELETE FROM `provincias`;
INSERT INTO `provincias` (`id`, `nome`) VALUES
	(1, 'Cabinda'),
	(2, 'Zaire'),
	(3, 'Uíge'),
	(4, 'Bengo'),
	(5, 'Luanda'),
	(6, 'Icolo e Bengo'),
	(7, 'Cuanza Norte'),
	(8, 'Cuanza Sul'),
	(9, 'Malanje'),
	(10, 'Lunda Norte'),
	(11, 'Lunda Sul'),
	(12, 'Moxico'),
	(13, 'Moxico Leste'),
	(14, 'Bié'),
	(15, 'Huambo'),
	(16, 'Benguela'),
	(17, 'Namibe'),
	(18, 'Huíla'),
	(19, 'Cunene'),
	(20, 'Cubango'),
	(21, 'Cuando');

-- A despejar estrutura para tabela sgh.tratamentos
CREATE TABLE IF NOT EXISTS `tratamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `diagnostico_id` int NOT NULL,
  `descricao` text NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `diagnostico_id` (`diagnostico_id`),
  CONSTRAINT `tratamentos_ibfk_1` FOREIGN KEY (`diagnostico_id`) REFERENCES `diagnosticos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.tratamentos: ~0 rows (aproximadamente)
DELETE FROM `tratamentos`;

-- A despejar estrutura para tabela sgh.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `genero` enum('M','F','O') NOT NULL,
  `email` varchar(100) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senha_gerada` tinyint DEFAULT NULL,
  `perfil` enum('superadmin','admin','medico','paciente','enfermeiro','recepcionista') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela sgh.usuarios: ~16 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `nome`, `genero`, `email`, `data_nascimento`, `senha`, `senha_gerada`, `perfil`, `criado_em`) VALUES
	(1, 'Sala', 'M', 'admin@sgh.com', '1990-10-28', '$2y$12$QuIOSCCmT2d0GAJdTkDsae6E6CHE9Nob6mONrVKhJmNhnW3hZ8Ffa', NULL, 'admin', '2025-09-21 17:16:39'),
	(2, 'Ana Diko', 'M', 'anadiiko@gmail.com', '2000-09-28', '$2y$12$x3/tTKLcvU23ImA9zLMmhOt5PmCrtiUJuUbvHD/x.18odLTT4WIMG', NULL, 'admin', '2025-09-22 04:13:22'),
	(3, 'Maria Clara Silva', 'F', 'mariaclara@sgh.com', '2025-10-28', '$2y$12$F8rI7AmMJC5MxfKTuPanFuuK4nYVXkOhUviGQEO81N.EWuVNpDco.', NULL, 'enfermeiro', '2025-09-22 04:20:38'),
	(4, 'Abraão Sala', 'M', 'abraaosala@hotmail.com', '1985-10-28', '$2y$12$vIgzkT6/Am140pLpYtoXMuSYo0VNudyawH/Ptr9BYE8kC0Q5jOU5W', 1, 'medico', '2025-09-22 04:21:48'),
	(5, 'Tiago José', 'M', 'tiago@gmail.co.ao', '2025-10-28', '$2y$12$H6H.IJSNrgGe7Pr9X.IuUOYgtZXbThSp1xe4OrS3FSMVZwjYe9JO.', 1, 'paciente', '2025-09-22 04:51:22'),
	(7, 'Maria Clara', 'F', 'cmaria@gmail.com', '2025-10-28', '$2y$12$Q0odsBgwrJyH5xVwrZ0Ow.Z2jUmvK9A.IF3V7S3hOJhTtHDQxRFXa', 1, 'medico', '2025-09-23 06:24:53'),
	(8, 'Maria Vianzevo', 'F', 'mariavia@gmail.com', '2025-10-28', '$2y$12$iWA.X/CwuBgQjI8qm/5QMuWr4J5BDCnG.xuZZbheOHK4H36m7jv9y', NULL, 'recepcionista', '2025-09-26 07:31:20'),
	(9, 'Madalena Simba', 'F', 'madasimbasala@gmail.com', '2025-10-28', '$2y$12$./EQ3hB2GQbOZJU7neLmF.wJp.GYIweoLdQqld/7EtjiGI29TH2ni', 1, 'paciente', '2025-09-27 07:10:38'),
	(10, 'Tiago Carlos', 'M', 'tiaguinhocarlos@gmail.com', '2025-10-28', '$2y$12$QjRNlwA5g4Oxbw34aF014envO4fD3/E4HmxCaqXzzQTanpYeZCE72', 1, 'paciente', '2025-09-27 07:14:59'),
	(11, 'Maria Silva', 'M', 'mari@sgh.com', '2025-10-28', '$2y$12$leCipJeSS2FliQJNHTf15.EqJqg2mC8/KLtADZUViRiJ0cFz75pI6', 1, 'medico', '2025-09-30 05:56:10'),
	(14, 'Joana Dacosta Malembe', 'F', 'joanadacostamalembe@gmail.com', '2000-08-20', '$2y$12$ArVDPhaeecYIuKc/VKbJfOtO.n7BtV1H49MBFpXPCdjBQwTb9N15q', NULL, 'paciente', '2025-12-17 00:50:10'),
	(15, 'Tiago Bernadeth', 'M', 'tiagoberna@gmail.com', '1996-08-20', '$2y$12$NW86Xlh1aowOKjUmRFcWuefrze/JIc/GCuKjKYQOo1V9m14/L4PpS', NULL, 'paciente', '2025-12-17 00:57:18'),
	(16, 'Elsa Amélia Sala', 'F', 'elsaamelia@gmail.com', NULL, '$2y$12$A/OX0QZMeOsz1M73RzLuNeC9LWZC5UOXo17TKnLn1Cby/uSTbV5m2', NULL, 'medico', '2025-12-21 07:02:09'),
	(17, 'Ricardo José', 'M', 'ricardo@gmail.com', NULL, '$2y$10$RuZs1PLaxAuqTgIBS2uy1ubnAcqM.jv/PQ0pMo6I7vwOdSDPezSBu', NULL, 'medico', '2026-01-08 09:45:42'),
	(22, 'Sandra Sala', 'F', 'sandra@gmail.com', NULL, '$2y$10$8byKoyqLmujJAHh2BwaaX.KrqeD3z5Y03KHLz.qXDV7TGnUCBEOr2', NULL, 'paciente', '2026-02-01 08:12:46'),
	(23, 'Pascoal', 'M', 'pascoal@gmail.ccom', NULL, '$2y$10$gEQeyHRE7s5RGwrlcbQK1.5ZK5akijYpDz.zsE1SBm/4gHrKKde.O', NULL, 'paciente', '2026-02-01 08:17:49');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
