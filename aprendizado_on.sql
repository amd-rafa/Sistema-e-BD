-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/05/2023 às 00:00
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aprendizado_on`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `in_usuar`
--
USE aprendizado_on;
CREATE TABLE `in_usuar` (
  `cd_usuar` varchar(100) NOT NULL,
  `nm_nome` varchar(300) NOT NULL,
  `dt_nascimento` date NOT NULL,
  `sexo` char(1) not null,
  `senha` varchar(255) not null,
  `in_email` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estrutura para tabela `in_cursos`
--

CREATE TABLE `in_cursos` (
  `id_curso` int(11) NOT NULL,
  `nm_curso` varchar(100) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `in_descri` varchar(200) NOT NULL,
  `vl_valor` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--

-- Estrutura para tabela `in_aulas`
--

CREATE TABLE `in_aulas` (
  `id_aula` int(11) NOT NULL,
  `nm_aula` varchar(200) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_prof` int(11) not null,
  `ds_conteudo` varchar(300) default null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estrutura para tabela `in_avalia`
--

CREATE TABLE `in_avalia` (
  `id_avalia` int(11) not null,
  `cd_usuar` varchar(100) not null,
  `id_aula` int(11) NOT NULL,
  `id_curso` varchar(100) NOT NULL,
  `id_prof` int(11) default null,
  `estrela` int(11) CHECK (estrela >= 1 AND estrela <= 5),
  `ds_avalia` text default null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--

-- Estrutura para tabela `in_inscricao`
--

CREATE TABLE `in_inscricao` (
	`id_inscricao` int(11) not null,
  `cd_usuar` varchar(100) NOT NULL,
  `id_curso` int(11) NOT NULL,
   `id_aula` int(11) not null,
   `in_email`varchar(255) default null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estrutura para tabela `cm_coment`
--

CREATE TABLE `cm_coment` (
`id_coment` int(11) not null,
  `id_aula` int(11) NOT NULL,
  `cd_usuar` varchar(100) NOT NULL,
  `id_curso` varchar(100) NOT NULL,
  `ds_coment` varchar(300) default null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estrutura para tabela `ct_categoria`
--

CREATE TABLE `ct_categoria` (
  `id_cat` int(11) NOT NULL,
  `nm_categoria` varchar(200) NOT NULL,
  `qt_curso` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estrutura para tabela `in_prof`
--

CREATE TABLE `in_prof` (
  `id_prof` int(11) NOT NULL,
  `cd_usuar` varchar (100) not null,
  `nm_prof` varchar(100) NOT NULL,
  `dt_nasci` date not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- Estrutura para tabela `in_progresso`
--

CREATE TABLE `in_progresso` (
  `cd_usuar` varchar(100) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `qt_curso` int(100) NOT NULL,
  `qt_final` int(100) NOT NULL,
  `qt_iniciado` int(100) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estrutura para tabela `in_certificado`
--

CREATE TABLE `in_certificado` (
  `id_certi` int(11) NOT NULL,
  `cd_usuar` varchar(100) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `dt_emi` date not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Índices para tabelas despejada
--
-- Índices de tabela `in_usuar`
--
ALTER TABLE `in_usuar`
  ADD PRIMARY KEY (`cd_usuar`);

--
-- Índices de tabela `in_cursos`
--
ALTER TABLE `in_cursos`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `id_cat`(`id_cat`);

--
-- Índices de tabela `in_aulas`
--
ALTER TABLE `in_aulas`
  ADD PRIMARY KEY (`id_aula`),
    ADD KEY `id_curso` (`id_curso`),
      ADD KEY `id_prof` (`id_prof`);
--
-- Índices de tabela `in_aulas`
--
ALTER TABLE `in_avalia`
  ADD PRIMARY KEY (`id_avalia`);
--

--
-- Índices de tabela `in_inscricao`
--
ALTER TABLE `in_inscricao`
  ADD PRIMARY KEY (`id_inscricao`),
    ADD KEY `cd_usuar` (`cd_usuar`),
      ADD KEY `id_curso` (`id_curso`),
      ADD KEY `id_aula` (`id_aula`);
      
      --
-- Índices de tabela `cm_coment`
--
ALTER TABLE `cm_coment`
  ADD PRIMARY KEY (`id_coment`),
  ADD KEY `cd_usuar` (`cd_usuar`),
    ADD KEY `id_curso` (`id_curso`),
      ADD KEY `id_aula` (`id_aula`);
      
--
-- Índices de tabela `ct_categoria`
--
ALTER TABLE `ct_categoria`
  ADD PRIMARY KEY (`id_cat`);
	
    --
-- Índices de tabela `in_prof`
--
ALTER TABLE `in_prof`
  ADD PRIMARY KEY (`id_prof`),
	ADD KEY `cd_usuar` (`CD_USUAR`);
  
  --
-- Índices de tabela `in_progresso`
--
ALTER TABLE `in_progresso`
    ADD PRIMARY KEY (`cd_usuar`),
    ADD KEY `id_curso` (`id_curso`);
    
    --
-- Índices de tabela `in_aulas`
--
ALTER TABLE `in_certificado`
  ADD PRIMARY KEY (`id_certi`),
    ADD KEY `cd_usuar` (`cd_usuar`),
      ADD KEY `id_curso` (`id_curso`);
      
      --
      
-- AUTO_INCREMENT para tabelas despejadas
--
-- AUTO_INCREMENT de tabela `in_cursos`
  
  ALTER TABLE `in_cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
  -- AUTO_INCREMENT de tabela `in_aulas`
  
  ALTER TABLE `in_aulas`
  MODIFY `id_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
   -- AUTO_INCREMENT de tabela `in_avalia`
  
  ALTER TABLE `in_avalia`
  MODIFY `id_avalia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
  -- AUTO_INCREMENT de tabela `in_inscricao`
  
  ALTER TABLE `in_inscricao`
  MODIFY `id_inscricao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
  
  -- AUTO_INCREMENT de tabela `cm_coment`
  
  ALTER TABLE `cm_coment`
  MODIFY `id_coment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
  -- AUTO_INCREMENT de tabela `ct_categoria`
  
  ALTER TABLE `ct_categoria`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
  -- AUTO_INCREMENT de tabela `in_prof`
  
  ALTER TABLE `in_prof`
  MODIFY `id_prof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--

--
-- AUTO_INCREMENT de tabela `in_certificado`
--
ALTER TABLE `in_certificado`
  MODIFY `id_certi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
