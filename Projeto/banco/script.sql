-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2021 at 06:48 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

CREATE DATABASE reserva_veiculo;
USE reserva_veiculo;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reserva_veiculo`
--

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `departamento`) VALUES
(1, 'Matadouro'),
(2, 'TI');

-- --------------------------------------------------------

--
-- Table structure for table `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `data_saida` datetime DEFAULT NULL,
  `data_retorno` datetime DEFAULT NULL,
  `status_reserva` tinytext DEFAULT NULL,
  `destino` varchar(150) DEFAULT NULL,
  `condutor` varchar(100) DEFAULT NULL,
  `motivo` varchar(150) DEFAULT NULL,
  `fk_id_departamento` int(11) NOT NULL,
  `fk_id_usuario` int(11) NOT NULL,
  `fk_id_veiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `data_saida`, `data_retorno`, `status_reserva`, `destino`, `condutor`, `motivo`, `fk_id_departamento`, `fk_id_usuario`, `fk_id_veiculo`) VALUES
(1, '2021-05-18 15:00:00', '2021-05-18 17:00:00', 'A', 'Prefeitura de Nova Esperança', 'Shaolin', 'Jogar truco com o prefeito', 1, 1, 4),
(2, '2021-05-25 13:30:00', '2021-05-25 14:30:00', 'A', 'Algum lugar top', 'Big big', 'Fazer nada, como sempre', 2, 1, 1),
(3, '2021-05-19 16:00:00', '2021-05-19 18:00:00', 'A', 'Catedral de Maringá', 'Papa Francisco', 'Rezar uma ave maria', 1, 1, 2),
(4, '2021-05-19 08:00:00', '2021-05-19 09:00:00', 'A', 'Rua dos Coqueiros', 'Kleblão', 'Conversar com cliente', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
  `fk_id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `cpf`, `senha`, `tipo`, `telefone`, `validade_cnh`, `cnh`, `fk_id_departamento`) VALUES
(1, 'Shaolin', '12345678901', 'c2hhb2xpbg==', 'A', '4498765432', '2024-05-15', '98765412365', 1),
(2, 'Kleblão', '12345678902', 'a2xlYmxhbw==', 'U', '44998745687', '2024-06-19', '78945874547', 2),
(3, 'Big Big', '12345678903', 'YmlnYmln', 'U', '44998745487', '2024-10-23', '12365478542', 2),
(4, 'Rodrigo Pato', '12345678904', 'cm9kcmlnbw==', 'A', '44998758789', '2025-06-18', '98745874587', 2),
(5, 'Gabriel', '12345678910', 'Z2FicmllbA==', 'A', '44998754874', '2024-02-17', '12345687878', 2);

-- --------------------------------------------------------

--
-- Table structure for table `veiculo`
--

CREATE TABLE `veiculo` (
  `id_veiculo` int(11) NOT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `placa` varchar(7) DEFAULT NULL,
  `proprietario` varchar(45) DEFAULT NULL,
  `status_veiculo` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `veiculo`
--

INSERT INTO `veiculo` (`id_veiculo`, `modelo`, `placa`, `proprietario`, `status_veiculo`) VALUES
(1, 'Patinete Xiaomi', 'ASD4568', 'Xi Jinping', 'A'),
(2, 'Monza 89', 'AST4587', 'Carlão', 'A'),
(3, 'Cavalo Mecânico', 'ASH9898', 'Sergão', 'A'),
(4, 'Corsa Rebaixado', 'DRF8724', 'Rodrigo Pato', 'A'),
(5, 'Fusca Azul', 'AVH4587', 'Ayrton Senna', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indexes for table `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_departamento` (`fk_id_departamento`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_id_departamento` (`fk_id_departamento`);

--
-- Indexes for table `veiculo`
--
ALTER TABLE `veiculo`
  ADD PRIMARY KEY (`id_veiculo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `id_veiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`fk_id_usuario`) REFERENCES `veiculo` (`id_veiculo`),
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`fk_id_departamento`) REFERENCES `departamento` (`id_departamento`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`fk_id_departamento`) REFERENCES `departamento` (`id_departamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
