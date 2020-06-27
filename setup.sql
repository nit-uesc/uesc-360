-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 02-Maio-2019 às 19:16
-- Versão do servidor: 5.7.20-0ubuntu0.17.04.1
-- PHP Version: 7.0.22-0ubuntu0.17.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uesc360`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `access_log`
--

CREATE TABLE `access_log` (
  `id_access_log` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `ip_usuario` varchar(20) NOT NULL,
  `data_acesso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `access_log`
--

INSERT INTO `access_log` (`id_access_log`, `id_usuario`, `ip_usuario`, `data_acesso`) VALUES
(416, 199, '::1', '2019-04-30 18:24:14'),
(417, 199, '::1', '2019-05-02 22:15:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `convite`
--

CREATE TABLE `convite` (
  `id_convite` int(11) NOT NULL,
  `fk_id_pessoa` int(11) NOT NULL COMMENT 'Pessoa que envio o convite',
  `email` varchar(100) NOT NULL COMMENT 'Email de quem vai ser convidado',
  `token` varchar(255) NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `falso` tinyint(1) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data_uso` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL COMMENT '	',
  `nome_cur` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id_curso`, `nome_cur`) VALUES
(34, 'Agroecologia '),
(31, 'Engenharia de Alimentos'),
(30, 'Técnico em Agrimensura'),
(33, 'Técnico em Agropecuária'),
(32, 'Técnico em Alimentos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `nome_dpt` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nome_dpt`) VALUES
(12, 'Centro de Tecnologia de Alimentos'),
(13, 'Núcleo de Agropecuária');

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamento`
--

CREATE TABLE `equipamento` (
  `id_equipamento` int(11) NOT NULL,
  `nome_eqp` varchar(100) NOT NULL,
  `fabricante_eqp` varchar(100) NOT NULL,
  `quantidade_eqp` int(11) NOT NULL,
  `especificacao_eqp` text NOT NULL,
  `descricao_eqp` text NOT NULL,
  `ativo_eqp` int(11) NOT NULL DEFAULT '1',
  `last_modified_eqp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `equipamento`
--

INSERT INTO `equipamento` (`id_equipamento`, `nome_eqp`, `fabricante_eqp`, `quantidade_eqp`, `especificacao_eqp`, `descricao_eqp`, `ativo_eqp`, `last_modified_eqp`) VALUES
(1, 'PH Metro de bancada', 'Mettler Toledo', 1, 'PH Metro de bancada. Tombo 72468. ', 'Medidor do potencial hidrogeniônico de uma substância.', 1, '2019-04-30 19:33:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamento_has_img`
--

CREATE TABLE `equipamento_has_img` (
  `id_equipamento_img` int(11) NOT NULL,
  `fk_id_img_equipamento` int(11) NOT NULL,
  `fk_id_equipamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `img_equipamento`
--

CREATE TABLE `img_equipamento` (
  `id_img_equipamento` int(11) NOT NULL,
  `nome_ime` varchar(60) NOT NULL,
  `nome_antigo_ime` varchar(60) NOT NULL,
  `tamanho_ime` float NOT NULL,
  `extensao_ime` varchar(5) NOT NULL,
  `ativo_ime` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `img_laboratorio`
--

CREATE TABLE `img_laboratorio` (
  `id_img_laboratorio` int(11) NOT NULL,
  `nome_iml` varchar(60) NOT NULL,
  `nome_antigo_iml` varchar(60) NOT NULL,
  `tamanho_iml` float NOT NULL,
  `extensao_iml` varchar(5) NOT NULL,
  `ativo_iml` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorio`
--

CREATE TABLE `laboratorio` (
  `id_laboratorio` int(11) NOT NULL,
  `nome_lab` varchar(200) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `ramal_lab` varchar(15) DEFAULT NULL,
  `website_lab` varchar(100) DEFAULT NULL,
  `descricao_lab` text NOT NULL,
  `atividades_lab` text NOT NULL,
  `areas_atendidas_lab` text NOT NULL,
  `multiusuario_lab` varchar(3) NOT NULL,
  `usa_ensino_lab` varchar(3) NOT NULL,
  `usa_pesquisa_lab` varchar(3) NOT NULL,
  `usa_extensao_lab` varchar(3) NOT NULL,
  `last_modified_lab` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_id_pavilhao` int(11) NOT NULL,
  `ativo_lab` int(11) NOT NULL DEFAULT '1',
  `palavras_chave` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `laboratorio`
--

INSERT INTO `laboratorio` (`id_laboratorio`, `nome_lab`, `sigla`, `ramal_lab`, `website_lab`, `descricao_lab`, `atividades_lab`, `areas_atendidas_lab`, `multiusuario_lab`, `usa_ensino_lab`, `usa_pesquisa_lab`, `usa_extensao_lab`, `last_modified_lab`, `fk_id_pavilhao`, `ativo_lab`, `palavras_chave`) VALUES
(1, 'Laboratório de Análise de Alimentos', 'LAA', '(73) 3239-2122', 'http://www.ifbaiano.edu.br/unidades/urucuca/', 'Laboratório atendimentos diversos.', 'Atividades de ensino, pesquisa e extensão.', 'Engenharias e alimentos.', 'Sim', 'Sim', 'Sim', 'Sim', '2019-04-30 19:26:59', 16, 1, 'engenharia alimentos inovação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorio_has_curso`
--

CREATE TABLE `laboratorio_has_curso` (
  `id_laboratorio_curso` int(11) NOT NULL,
  `fk_id_laboratorio` int(11) NOT NULL,
  `fk_id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `laboratorio_has_curso`
--

INSERT INTO `laboratorio_has_curso` (`id_laboratorio_curso`, `fk_id_laboratorio`, `fk_id_curso`) VALUES
(1, 1, 31),
(2, 1, 32);

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorio_has_departamento`
--

CREATE TABLE `laboratorio_has_departamento` (
  `id_laboratorio_departamento` int(11) NOT NULL,
  `fk_id_laboratorio` int(11) NOT NULL,
  `fk_id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `laboratorio_has_departamento`
--

INSERT INTO `laboratorio_has_departamento` (`id_laboratorio_departamento`, `fk_id_laboratorio`, `fk_id_departamento`) VALUES
(1, 1, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorio_has_equipamento`
--

CREATE TABLE `laboratorio_has_equipamento` (
  `id_laboratorio_equipamento` int(11) NOT NULL,
  `fk_id_equipamento` int(11) NOT NULL,
  `fk_id_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `laboratorio_has_equipamento`
--

INSERT INTO `laboratorio_has_equipamento` (`id_laboratorio_equipamento`, `fk_id_equipamento`, `fk_id_laboratorio`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorio_has_img`
--

CREATE TABLE `laboratorio_has_img` (
  `id_laboratorio_img` int(11) NOT NULL,
  `fk_id_laboratorio` int(11) NOT NULL,
  `fk_id_img_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorio_has_pessoa`
--

CREATE TABLE `laboratorio_has_pessoa` (
  `id_laboratorio_pessoa` int(11) NOT NULL,
  `fk_id_laboratorio` int(11) NOT NULL,
  `fk_id_pessoa` int(11) NOT NULL,
  `permissao_lhp` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `laboratorio_has_pessoa`
--

INSERT INTO `laboratorio_has_pessoa` (`id_laboratorio_pessoa`, `fk_id_laboratorio`, `fk_id_pessoa`, `permissao_lhp`) VALUES
(1, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `laboratorio_has_regulamento`
--

CREATE TABLE `laboratorio_has_regulamento` (
  `id_laboratorio_regulamento` int(11) NOT NULL,
  `fk_id_regulamento` int(11) NOT NULL,
  `fk_id_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pavilhao`
--

CREATE TABLE `pavilhao` (
  `id_pavilhao` int(11) NOT NULL,
  `nome_pav` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pavilhao`
--

INSERT INTO `pavilhao` (`id_pavilhao`, `nome_pav`) VALUES
(16, 'IF Baiano - campus Uruçuca');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_cadastro`
--

CREATE TABLE `pedido_cadastro` (
  `id_pedido_cadastro` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `falso` tinyint(1) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data_uso` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `id_permissao` int(11) NOT NULL,
  `descricao_per` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `permissao`
--

INSERT INTO `permissao` (`id_permissao`, `descricao_per`) VALUES
(1, 'Administrador'),
(2, 'Coordenador'),
(3, 'Usuário');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `id_pessoa` int(11) NOT NULL,
  `nome_pes` varchar(50) NOT NULL,
  `email_pes` varchar(45) NOT NULL,
  `cpf_pes` varchar(14) DEFAULT NULL,
  `ramal_pes` varchar(15) DEFAULT NULL,
  `lattes_pes` varchar(70) DEFAULT NULL,
  `website_pes` varchar(50) DEFAULT NULL,
  `fk_id_tipo_pessoa` int(11) NOT NULL,
  `fk_id_departamento` int(11) NOT NULL,
  `fk_id_usuario` int(11) DEFAULT NULL,
  `birthday_pes` date DEFAULT NULL,
  `sexo_pes` char(1) NOT NULL,
  `ativo_pes` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `nome_pes`, `email_pes`, `cpf_pes`, `ramal_pes`, `lattes_pes`, `website_pes`, `fk_id_tipo_pessoa`, `fk_id_departamento`, `fk_id_usuario`, `birthday_pes`, `sexo_pes`, `ativo_pes`) VALUES
(1, 'Josué de Souza Oliveira', 'josue.oliveira@ifbaiano.edu.br', '602.764.285-87', '(73) 3239-2122', 'http://lattes.cnpq.br/4893541221079715', 'http://www.ifbaiano.edu.br/unidades/urucuca/', 2, 12, 200, '1973-05-01', 'M', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `recuperar_senha`
--

CREATE TABLE `recuperar_senha` (
  `id_recuperar_senha` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `falso` tinyint(1) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data_uso` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `regulamento_laboratorio`
--

CREATE TABLE `regulamento_laboratorio` (
  `id_reg_lab` int(11) NOT NULL,
  `nome_reg_lab` varchar(100) DEFAULT NULL,
  `nome_antigo_reg_lab` varchar(100) DEFAULT NULL,
  `nome_reg_infor` varchar(100) DEFAULT NULL,
  `tam_reg_lab` float DEFAULT NULL,
  `extensao_reg_lab` varchar(5) DEFAULT NULL,
  `descricao_regulamento` varchar(400) DEFAULT NULL,
  `ativo_reg_lab` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_pessoa`
--

CREATE TABLE `tipo_pessoa` (
  `id_tipo_pessoa` int(11) NOT NULL,
  `tipo_tip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_pessoa`
--

INSERT INTO `tipo_pessoa` (`id_tipo_pessoa`, `tipo_tip`) VALUES
(1, 'ALUNO'),
(2, 'COORDENADOR'),
(3, 'PROFESSOR'),
(4, 'SETOR'),
(5, 'TÉCNICO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `login_usu` varchar(50) NOT NULL,
  `senha_usu` varchar(50) NOT NULL,
  `ativo_usu` int(11) NOT NULL DEFAULT '1',
  `permissao_usu` int(11) NOT NULL DEFAULT '3',
  `first_access_usu` int(11) NOT NULL DEFAULT '1',
  `data_cadastro_usu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `login_usu`, `senha_usu`, `ativo_usu`, `permissao_usu`, `first_access_usu`, `data_cadastro_usu`) VALUES
(199, 'admin', '77fb57f01843d0698cf3faa31507a6d4b36bef92', 1, 1, 1, '2017-10-17 21:41:16'),
(200, 'josue.oliveira@ifbaiano.edu.br', '254c7e969967a4c962c537f1a87e87b1d985bf4d', 1, 3, 1, '2019-04-30 19:04:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_has_permissao`
--

CREATE TABLE `usuario_has_permissao` (
  `id_usuario_has_permissao` int(11) NOT NULL,
  `fk_id_usuario` int(11) NOT NULL,
  `fk_id_permissao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario_has_permissao`
--

INSERT INTO `usuario_has_permissao` (`id_usuario_has_permissao`, `fk_id_usuario`, `fk_id_permissao`) VALUES
(174, 199, 1),
(175, 200, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_log`
--
ALTER TABLE `access_log`
  ADD PRIMARY KEY (`id_access_log`);

--
-- Indexes for table `convite`
--
ALTER TABLE `convite`
  ADD PRIMARY KEY (`id_convite`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome_cur`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome_dpt`);

--
-- Indexes for table `equipamento`
--
ALTER TABLE `equipamento`
  ADD PRIMARY KEY (`id_equipamento`);

--
-- Indexes for table `equipamento_has_img`
--
ALTER TABLE `equipamento_has_img`
  ADD PRIMARY KEY (`id_equipamento_img`),
  ADD KEY `fk_id_img_equipamento_idx` (`fk_id_img_equipamento`),
  ADD KEY `fk_id_equipamento_idx` (`fk_id_equipamento`);

--
-- Indexes for table `img_equipamento`
--
ALTER TABLE `img_equipamento`
  ADD PRIMARY KEY (`id_img_equipamento`);

--
-- Indexes for table `img_laboratorio`
--
ALTER TABLE `img_laboratorio`
  ADD PRIMARY KEY (`id_img_laboratorio`);

--
-- Indexes for table `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`id_laboratorio`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome_lab`),
  ADD KEY `fk_id_pavilhao_idx` (`fk_id_pavilhao`);

--
-- Indexes for table `laboratorio_has_curso`
--
ALTER TABLE `laboratorio_has_curso`
  ADD PRIMARY KEY (`id_laboratorio_curso`),
  ADD KEY `fk_id_laboratorio_idx` (`fk_id_laboratorio`),
  ADD KEY `fk_curso_idx` (`fk_id_curso`);

--
-- Indexes for table `laboratorio_has_departamento`
--
ALTER TABLE `laboratorio_has_departamento`
  ADD PRIMARY KEY (`id_laboratorio_departamento`),
  ADD KEY `fk_id_laboratorio_idx` (`fk_id_laboratorio`),
  ADD KEY `fk_id_departamento_idx` (`fk_id_departamento`);

--
-- Indexes for table `laboratorio_has_equipamento`
--
ALTER TABLE `laboratorio_has_equipamento`
  ADD PRIMARY KEY (`id_laboratorio_equipamento`),
  ADD KEY `fk_id_equipamento_idx` (`fk_id_equipamento`),
  ADD KEY `fk_id_laboratorio_idx` (`fk_id_laboratorio`);

--
-- Indexes for table `laboratorio_has_img`
--
ALTER TABLE `laboratorio_has_img`
  ADD PRIMARY KEY (`id_laboratorio_img`),
  ADD KEY `fk_id_laboratorio_idx` (`fk_id_laboratorio`),
  ADD KEY `fk_id_img_laboratorio_idx` (`fk_id_img_laboratorio`);

--
-- Indexes for table `laboratorio_has_pessoa`
--
ALTER TABLE `laboratorio_has_pessoa`
  ADD PRIMARY KEY (`id_laboratorio_pessoa`),
  ADD KEY `fk_id_laboratorio_idx` (`fk_id_laboratorio`),
  ADD KEY `fk_id_pessoa_idx` (`fk_id_pessoa`);

--
-- Indexes for table `laboratorio_has_regulamento`
--
ALTER TABLE `laboratorio_has_regulamento`
  ADD PRIMARY KEY (`id_laboratorio_regulamento`),
  ADD KEY `fk_id_regulamento` (`fk_id_regulamento`),
  ADD KEY `fk_id_laboratorio` (`fk_id_laboratorio`);

--
-- Indexes for table `pavilhao`
--
ALTER TABLE `pavilhao`
  ADD PRIMARY KEY (`id_pavilhao`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome_pav`);

--
-- Indexes for table `pedido_cadastro`
--
ALTER TABLE `pedido_cadastro`
  ADD PRIMARY KEY (`id_pedido_cadastro`);

--
-- Indexes for table `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id_permissao`);

--
-- Indexes for table `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id_pessoa`),
  ADD KEY `fk_id_usuario_idx` (`fk_id_usuario`),
  ADD KEY `fk_id_tipo_pessoa_idx` (`fk_id_tipo_pessoa`),
  ADD KEY `fk_id_departamento_idx` (`fk_id_departamento`);

--
-- Indexes for table `recuperar_senha`
--
ALTER TABLE `recuperar_senha`
  ADD PRIMARY KEY (`id_recuperar_senha`);

--
-- Indexes for table `regulamento_laboratorio`
--
ALTER TABLE `regulamento_laboratorio`
  ADD PRIMARY KEY (`id_reg_lab`);

--
-- Indexes for table `tipo_pessoa`
--
ALTER TABLE `tipo_pessoa`
  ADD PRIMARY KEY (`id_tipo_pessoa`),
  ADD UNIQUE KEY `tipo_UNIQUE` (`tipo_tip`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login_usu`);

--
-- Indexes for table `usuario_has_permissao`
--
ALTER TABLE `usuario_has_permissao`
  ADD PRIMARY KEY (`id_usuario_has_permissao`),
  ADD KEY `fk_usuario` (`fk_id_usuario`),
  ADD KEY `fk_permissao` (`fk_id_permissao`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_log`
--
ALTER TABLE `access_log`
  MODIFY `id_access_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;
--
-- AUTO_INCREMENT for table `convite`
--
ALTER TABLE `convite`
  MODIFY `id_convite` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT COMMENT '	', AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `equipamento`
--
ALTER TABLE `equipamento`
  MODIFY `id_equipamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `equipamento_has_img`
--
ALTER TABLE `equipamento_has_img`
  MODIFY `id_equipamento_img` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `img_equipamento`
--
ALTER TABLE `img_equipamento`
  MODIFY `id_img_equipamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `img_laboratorio`
--
ALTER TABLE `img_laboratorio`
  MODIFY `id_img_laboratorio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `id_laboratorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `laboratorio_has_curso`
--
ALTER TABLE `laboratorio_has_curso`
  MODIFY `id_laboratorio_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `laboratorio_has_departamento`
--
ALTER TABLE `laboratorio_has_departamento`
  MODIFY `id_laboratorio_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `laboratorio_has_equipamento`
--
ALTER TABLE `laboratorio_has_equipamento`
  MODIFY `id_laboratorio_equipamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `laboratorio_has_img`
--
ALTER TABLE `laboratorio_has_img`
  MODIFY `id_laboratorio_img` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `laboratorio_has_pessoa`
--
ALTER TABLE `laboratorio_has_pessoa`
  MODIFY `id_laboratorio_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `laboratorio_has_regulamento`
--
ALTER TABLE `laboratorio_has_regulamento`
  MODIFY `id_laboratorio_regulamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pavilhao`
--
ALTER TABLE `pavilhao`
  MODIFY `id_pavilhao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pedido_cadastro`
--
ALTER TABLE `pedido_cadastro`
  MODIFY `id_pedido_cadastro` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissao`
--
ALTER TABLE `permissao`
  MODIFY `id_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `recuperar_senha`
--
ALTER TABLE `recuperar_senha`
  MODIFY `id_recuperar_senha` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `regulamento_laboratorio`
--
ALTER TABLE `regulamento_laboratorio`
  MODIFY `id_reg_lab` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo_pessoa`
--
ALTER TABLE `tipo_pessoa`
  MODIFY `id_tipo_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT for table `usuario_has_permissao`
--
ALTER TABLE `usuario_has_permissao`
  MODIFY `id_usuario_has_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `equipamento_has_img`
--
ALTER TABLE `equipamento_has_img`
  ADD CONSTRAINT `fk_ei_id_equipamento` FOREIGN KEY (`fk_id_equipamento`) REFERENCES `equipamento` (`id_equipamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ei_id_img_equipamento` FOREIGN KEY (`fk_id_img_equipamento`) REFERENCES `img_equipamento` (`id_img_equipamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD CONSTRAINT `fk_lab_id_pavilhao` FOREIGN KEY (`fk_id_pavilhao`) REFERENCES `pavilhao` (`id_pavilhao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `laboratorio_has_curso`
--
ALTER TABLE `laboratorio_has_curso`
  ADD CONSTRAINT `fk_lc_curso` FOREIGN KEY (`fk_id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lc_id_laboratorio` FOREIGN KEY (`fk_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `laboratorio_has_departamento`
--
ALTER TABLE `laboratorio_has_departamento`
  ADD CONSTRAINT `fk_ld_id_departamento` FOREIGN KEY (`fk_id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ld_id_laboratorio` FOREIGN KEY (`fk_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `laboratorio_has_equipamento`
--
ALTER TABLE `laboratorio_has_equipamento`
  ADD CONSTRAINT `fk_le_id_equipamento` FOREIGN KEY (`fk_id_equipamento`) REFERENCES `equipamento` (`id_equipamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_le_id_laboratorio` FOREIGN KEY (`fk_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `laboratorio_has_img`
--
ALTER TABLE `laboratorio_has_img`
  ADD CONSTRAINT `fk_li_id_img_laboratorio` FOREIGN KEY (`fk_id_img_laboratorio`) REFERENCES `img_laboratorio` (`id_img_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_li_id_laboratorio` FOREIGN KEY (`fk_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `laboratorio_has_pessoa`
--
ALTER TABLE `laboratorio_has_pessoa`
  ADD CONSTRAINT `fk_lp_id_laboratorio` FOREIGN KEY (`fk_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lp_id_pessoa` FOREIGN KEY (`fk_id_pessoa`) REFERENCES `pessoa` (`id_pessoa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `laboratorio_has_regulamento`
--
ALTER TABLE `laboratorio_has_regulamento`
  ADD CONSTRAINT `laboratorio_has_regulamento_ibfk_1` FOREIGN KEY (`fk_id_regulamento`) REFERENCES `regulamento_laboratorio` (`id_reg_lab`),
  ADD CONSTRAINT `laboratorio_has_regulamento_ibfk_2` FOREIGN KEY (`fk_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`);

--
-- Limitadores para a tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `fk_pes_id_departamento` FOREIGN KEY (`fk_id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pes_id_tipo_pessoa` FOREIGN KEY (`fk_id_tipo_pessoa`) REFERENCES `tipo_pessoa` (`id_tipo_pessoa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pes_id_usuario` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `usuario_has_permissao`
--
ALTER TABLE `usuario_has_permissao`
  ADD CONSTRAINT `fk_permissao_uhp` FOREIGN KEY (`fk_id_permissao`) REFERENCES `permissao` (`id_permissao`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_uhp` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
