-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2021 at 04:41 PM
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
(1, 'TI'),
(2, 'Vendas'),
(3, 'Marketing'),
(4, 'Suporte');

-- --------------------------------------------------------

--
-- Table structure for table `reserva`
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
-- Dumping data for table `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `data_saida`, `data_saida_real`, `data_retorno`, `data_retorno_real`, `km_saida`, `km_retorno`, `status_reserva`, `destino`, `condutor`, `motivo`, `fk_id_departamento`, `fk_id_usuario`, `fk_id_veiculo`) VALUES
(1, '2021-06-02 12:00:00', NULL, '2021-06-02 13:00:00', NULL, NULL, NULL, 'A', 'Prefeitura de Nova Esperança', 'Shaolin', 'Jogar truco com o prefeito', 1, 1, 1),
(2, '2021-06-03 18:00:00', NULL, '2021-06-03 19:00:00', NULL, NULL, NULL, 'A', 'Catedral de Maringá', 'Papa Francisco', 'Rezar uma ave maria', 4, 1, 2),
(3, '2021-06-03 13:00:00', NULL, '2021-06-03 14:00:00', NULL, NULL, NULL, 'A', 'Alemanha', 'Ayrton Senna', 'Ganhar a F1', 4, 1, 3);

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
(1, 'Shaolin', '12345678901', 'c2hhb2xpbg==', 'A', '44132131232', '2027-06-18', '15649849489', 1),
(2, 'Kleblão', '12345678902', 'a2xlYmxhbw==', 'U', '44858686868', '2029-06-14', '47237472347', 1),
(3, 'Rodrigo Pato', '46545465456', 'cm9kcmlnbw==', 'A', '44998758789', '2035-06-15', '54645464646', 1),
(4, 'Big Big', '45646546548', 'YmlnYmln', 'U', '44766745645', '2035-06-14', '78484848484', 3);

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
(1, 'Monza 89', 'ADS1343', 'Kleber Pedra', 'A'),
(2, 'Patinete Xiaomi', 'AGH4323', 'Xi Jinping', 'A'),
(3, 'Fusca Azul', 'ASM5465', 'Ayrton Senna', 'A'),
(4, 'Corsa Rebaixado', 'ASD8676', 'Rogerinho', 'A');

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
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `id_veiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
