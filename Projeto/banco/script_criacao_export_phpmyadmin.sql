-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Jun-2021 às 18:20
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `reserva_veiculo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  `status_departamento` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `departamento`, `status_departamento`) VALUES
(1, 'TI', 'A'),
(2, 'Vendas', 'A'),
(3, 'Marketing', 'A'),
(4, 'Suporte', 'A'),
(5, 'Gerencia', 'A'),
(6, 'RH', 'A'),
(7, 'Diretoria', 'A'),
(8, 'teste', 'I');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `data_saida` datetime DEFAULT NULL,
  `data_saida_real` datetime DEFAULT NULL,
  `data_retorno` datetime DEFAULT NULL,
  `data_retorno_real` datetime DEFAULT NULL,
  `km_saida` int(11) DEFAULT NULL,
  `km_retorno` int(11) DEFAULT NULL,
  `status_reserva` tinytext DEFAULT NULL,
  `destino` varchar(150) DEFAULT NULL,
  `condutor` varchar(100) DEFAULT NULL,
  `motivo` varchar(150) DEFAULT NULL,
  `fk_id_departamento` int(11) NOT NULL,
  `fk_id_usuario` int(11) NOT NULL,
  `fk_id_veiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `data_saida`, `data_saida_real`, `data_retorno`, `data_retorno_real`, `km_saida`, `km_retorno`, `status_reserva`, `destino`, `condutor`, `motivo`, `fk_id_departamento`, `fk_id_usuario`, `fk_id_veiculo`) VALUES
(1, '2021-06-20 20:54:00', NULL, '2021-06-20 21:54:00', NULL, NULL, NULL, 'A', 'aaaaaa', 'aaaaa', 'aaaaaaa', 1, 1, 1),
(4, '2021-06-21 10:43:00', NULL, '2021-06-21 11:43:00', NULL, NULL, NULL, 'A', 'cccccc', 'cccccccc', 'cccccccc', 1, 1, 2),
(5, '2021-06-21 10:51:00', NULL, '2021-06-21 12:51:00', NULL, NULL, NULL, 'A', 'zzz', 'zzzzzz', 'zzzzz', 1, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `tipo` tinytext DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `validade_cnh` date DEFAULT NULL,
  `cnh` varchar(11) DEFAULT NULL,
  `status_usuario` tinytext DEFAULT NULL,
  `fk_id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `cpf`, `senha`, `tipo`, `telefone`, `validade_cnh`, `cnh`, `status_usuario`, `fk_id_departamento`) VALUES
(1, 'Shaolin', '12345678901', 'c2hhb2xpbg==', 'A', '44998765432', '2024-06-12', '63563567891', 'A', 1),
(2, 'Kleblão', '12345678902', 'a2xlYmxhbw==', 'U', '44992138381', '2023-06-14', '32173217312', 'A', 1),
(3, 'Rodrigo Pato', '12345678903', 'cGF0bw==', 'U', '44998765763', '2027-06-17', '82131283128', 'A', 1),
(4, 'Rafael Gigante', '12345678904', 'YmlnYmln', 'U', '44998767656', '2027-06-23', '36612361723', 'A', 1),
(5, 'Putzzz Jhony', '12345678905', 'cHV0enp6', 'A', '44998373737', '2027-06-23', '12371273721', 'A', 6),
(6, 'Carlão', '12345678906', 'cHl0aG9u', 'U', '44973892173', '2027-06-23', '83127893712', 'I', 4),
(7, 'Emerson', '12345678907', 'bWljcm9zb2Z0', 'A', '44998219381', '2027-06-23', '29138912839', 'A', 7),
(8, 'Teste', '21321631263', 'dGVzdGU=', 'U', '44998381218', '2021-06-22', '36123126123', 'I', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculo`
--

CREATE TABLE `veiculo` (
  `id_veiculo` int(11) NOT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `placa` varchar(7) DEFAULT NULL,
  `proprietario` varchar(45) DEFAULT NULL,
  `status_veiculo` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `veiculo`
--

INSERT INTO `veiculo` (`id_veiculo`, `modelo`, `placa`, `proprietario`, `status_veiculo`) VALUES
(1, 'Corsa rebaixado', 'ASD3948', 'Rodrigo Pato', 'A'),
(2, 'Patinete Xiaomi', 'ASD0434', 'Xi Jinping', 'A'),
(3, 'Fusca azul', 'ADS9473', 'Ayrton Senna', 'A'),
(4, 'Touro mecânico', 'ADS0483', 'Serjão Berranteiro', 'A'),
(6, 'Fiat 147', 'DAS0312', 'Jhony', 'A'),
(7, 'Gol bolinha', 'ASD0384', 'Xao xao', 'A'),
(8, 'Gol quadrado', 'ASD0383', 'Zézão', 'A'),
(9, 'Honda pop', 'KDI9383', 'Dona maria', 'A'),
(10, 'Burro de carga', 'ADS8374', 'Big big', 'A'),
(11, 'Nissan tunado', 'ADK9381', 'Alguém', 'A'),
(12, 'Honda civic', 'ADS8382', 'Alguém top', 'A'),
(13, 'Carroça', 'ASD1231', 'Jaime da roça', 'A');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Índices para tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_departamento` (`fk_id_departamento`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_id_departamento` (`fk_id_departamento`);

--
-- Índices para tabela `veiculo`
--
ALTER TABLE `veiculo`
  ADD PRIMARY KEY (`id_veiculo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `id_veiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`fk_id_usuario`) REFERENCES `veiculo` (`id_veiculo`),
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`fk_id_departamento`) REFERENCES `departamento` (`id_departamento`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`fk_id_departamento`) REFERENCES `departamento` (`id_departamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
