-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2025 às 18:16
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `clinica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL,
  `nome_paciente` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `data_consulta` date DEFAULT NULL,
  `descricao` varchar(500) NOT NULL,
  `nome_medico` varchar(100) DEFAULT NULL,
  `foto_paciente` varchar(50) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `consulta`
--

INSERT INTO `consulta` (`id_consulta`, `nome_paciente`, `cpf`, `email`, `cep`, `telefone`, `data_consulta`, `descricao`, `nome_medico`, `foto_paciente`, `endereco`, `bairro`, `cidade`, `Estado`, `hora`) VALUES
(12, 'Lima', '$2y$10$79zM213', '$2y$10$XJarO4OTF9QwvFETjyxoZO79sIQpdRddBoijhipZ0qx66GvPTY4w6', '$2y$10$Jkz', '(21) 97407-976', '2025-11-28', 'q', 'Daniel Oliveira', 'uploads/paciente_69285df7d3fcf3.69318469.png', '', '', '', '', '00:00:00'),
(15, 'Chad Jesus Christo da Silva', '$2y$10$VuZ6Y8P', '$2y$10$Oe9kGKE0z0S9FESWiGhINuk.BfOv0jwD58g8oIv4O8nTBjENZhXpW', '$2y$10$TYj', '(25) 9 9773-66', '2025-11-28', 'He\'s the lord. ', 'Daniel Oliveira', 'uploads/paciente_69286a97b17010.77139640.jpeg', '', '', '', '', '00:00:00'),
(16, 'Antonio Ryan z', '$2y$10$wZ/lk90', '$2y$10$X98Wes8FjTZaqNVLG3VfD.Fu1W1QTUGDS3KnvSBMpAXnWCt75hQRS', '$2y$10$pmd', '(48) 9 9832-63', '2025-12-03', 'Bebado', 'Daniel Oliveira', 'uploads/paciente_69286b0d7563b0.58158597.jpeg', '', '', '', '', '00:00:00'),
(17, 'Ximira', '$2y$10$D0dli/W', '$2y$10$ATgFVT7IeGYHFuAOgb5DSe.dBXeNDeLKkgABc5oxTP7t.DwE0Hifu', '$2y$10$1Zl', '(21) 97407-976', '2025-11-27', 'a', 'Ana Silva', 'uploads/paciente_69290fbabd45c3.60705096.jpg', '', '', '', '', '00:00:00'),
(19, 'Antonio Ryan carlos', '$2y$10$qeMgk0a', '$2y$10$AEi8HHa1dMqPCsIpxtJCw.6HKhWBKdgnEkvbbEoF5b5Ai7VyKKHQa', '$2y$10$nSg', '(21) 97407-976', '2025-11-27', 'w', 'Eduarda Costa', 'uploads/paciente_6929aa7974dfd2.29870990.jpg', '', '', '', '', '23:57:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `senha` varchar(260) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `login`
--

INSERT INTO `login` (`id_login`, `nome`, `email`, `senha`) VALUES
(7, 'nico', 'ruan-galvao98@lojascentrodamoda.com.b', '$2y$10$kRZ8U3SXTEjfVeKV0nJrFu7AuNLaLSBO488yabxoOvRkCoOiUp6Om'),
(8, 'z', 'velika1521@uorak.com', '$2y$10$r8py7QOaG.Fga4jUHOT3bOfiQCO5mRoi/881WXk55bl2iwvTnt5Ge');

-- --------------------------------------------------------

--
-- Estrutura para tabela `medico`
--

CREATE TABLE `medico` (
  `id_medico` int(100) NOT NULL,
  `crm` varchar(14) DEFAULT NULL,
  `nome_medico` varchar(100) DEFAULT NULL,
  `especializacao` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medico`
--

INSERT INTO `medico` (`id_medico`, `crm`, `nome_medico`, `especializacao`, `telefone`) VALUES
(1, '123456', 'Ana Silva', 'Dermatologista', '(11) 98765-4321'),
(2, '789012', 'Bruno Mendes', 'Dermatologia', '(21) 97654-3210'),
(3, '345678', 'Clara Santos', 'Ortopedia', '(31) 96543-2109'),
(4, '901234', 'Daniel Oliveira', 'Pediatria', '(41) 95432-1098'),
(5, '567890', 'Eduarda Costa', 'Ginecologia', '(51) 94321-0987'),
(6, '102938', 'Felipe Rocha', 'Geral', '(61) 93210-9876'),
(7, '472583', 'Gabriela Lima', 'Oftalmologia', '(71) 92109-8765'),
(8, '693147', 'Henrique Alves', 'Urologia', '(81) 91098-7654'),
(9, '258096', 'Isabella Souza', 'Ginecologista', '(91) 90987-6543'),
(10, '837465', 'João Pereira', 'Geral', '(12) 99876-5432'),
(11, '591726', 'Laura Fernandes', 'Oftalmologista', '(22) 98765-4321'),
(12, '306815', 'Marcelo Gomes', 'Geral', '(32) 97654-3210'),
(13, '228922', 'kaka santos', 'cardiologia', '(21) 97407-9767');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cep` (`cep`),
  ADD KEY `nome_medico` (`nome_medico`);

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `senha` (`senha`);

--
-- Índices de tabela `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id_medico`),
  ADD UNIQUE KEY `crm` (`crm`),
  ADD UNIQUE KEY `nome_medico` (`nome_medico`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `medico`
--
ALTER TABLE `medico`
  MODIFY `id_medico` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`nome_medico`) REFERENCES `medico` (`nome_medico`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
