CREATE DATABASE reserva_veiculo;

USE reserva_veiculo;

CREATE TABLE departamento(
  id_departamento int NOT NULL AUTO_INCREMENT,
  departamento varchar(45),
  status_departamento text(1),
  PRIMARY KEY (id_departamento)
);

INSERT INTO `departamento` (`id_departamento`, `departamento`, `status_departamento`) VALUES
(1, 'TI', 'A'),
(2, 'Vendas', 'A'),
(3, 'Marketing', 'A'),
(4, 'Suporte', 'A'),
(5, 'Gerencia', 'A'),
(6, 'RH', 'A'),
(7, 'Diretoria', 'A');

CREATE TABLE usuario(
  id_usuario int NOT NULL AUTO_INCREMENT,
  nome varchar(100),
  cpf varchar(11),
  senha varchar(45),
  tipo text(1),
  telefone varchar (11),
  validade_cnh date,
  cnh varchar (11),
  status_usuario text(1),
  fk_id_departamento int NOT NULL,
  PRIMARY KEY (id_usuario),
  FOREIGN KEY (fk_id_departamento) REFERENCES departamento(id_departamento)
);

INSERT INTO `usuario` (`id_usuario`, `nome`, `cpf`, `senha`, `tipo`, `telefone`, `validade_cnh`, `cnh`, `status_usuario`, `fk_id_departamento`) VALUES
(1, 'Shaolin', '12345678901', 'c2hhb2xpbg==', 'A', '44998765432', '2024-06-12', '63563567891', 'A', 1),
(2, 'Kleblão', '12345678902', 'a2xlYmxhbw==', 'U', '44992138381', '2023-06-14', '32173217312', 'A', 1),
(3, 'Rodrigo Pato', '12345678903', 'cGF0bw==', 'U', '44998765763', '2027-06-17', '82131283128', 'A', 1),
(4, 'Rafael Gigante', '12345678904', 'YmlnYmln', 'U', '44998767656', '2027-06-23', '36612361723', 'A', 1),
(5, 'Putzzz Jhony', '12345678905', 'cHV0enp6', 'A', '44998373737', '2027-06-23', '12371273721', 'A', 6),
(6, 'Carlão', '12345678906', 'cHl0aG9u', 'U', '44973892173', '2027-06-23', '83127893712', 'A', 4),
(7, 'Emerson', '12345678907', 'bWljcm9zb2Z0', 'A', '44998219381', '2027-06-23', '29138912839', 'A', 7);

CREATE TABLE veiculo(
  id_veiculo int NOT NULL AUTO_INCREMENT,
  modelo varchar(45),
  placa varchar(7),
  proprietario varchar(45),
  status_veiculo text(1),
  PRIMARY KEY (id_veiculo)
);

INSERT INTO `veiculo` (`id_veiculo`, `modelo`, `placa`, `proprietario`, `status_veiculo`) VALUES
(1, 'Corsa rebaixado', 'ASD3948', 'Rodrigo Pato', 'A'),
(2, 'Patinete Xiaomi', 'ASD0434', 'Xi Jinping', 'A'),
(3, 'Fusca azul', 'ADS9473', 'Ayrton Senna', 'A'),
(4, 'Touro mecânico', 'ADS0483', 'Serjão Berranteiro', 'A'),
(5, 'Carroça', 'KDS0348', 'Jaime da roça', 'A'),
(6, 'Fiat 147', 'DAS0312', 'Jhony', 'A'),
(7, 'Gol bolinha', 'ASD0384', 'Xao xao', 'A'),
(8, 'Gol quadrado', 'ASD0383', 'Zézão', 'A'),
(9, 'Honda pop', 'KDI9383', 'Dona maria', 'A'),
(10, 'Burro de carga', 'ADS8374', 'Big big', 'A'),
(11, 'Nissan tunado', 'ADK9381', 'Alguém', 'A'),
(12, 'Honda civic', 'ADS8382', 'Alguém top', 'A');

CREATE TABLE reserva(
  id_reserva int NOT NULL AUTO_INCREMENT,
  data_saida datetime,
  data_saida_real datetime,
  data_retorno datetime,
  data_retorno_real datetime,
  km_saida int(11),
  km_retorno int(11),
  status_reserva text(1),
  destino varchar(150),
  condutor varchar(100),
  motivo varchar(150),
  fk_id_departamento int NOT NULL,
  fk_id_usuario int NOT NULL,
  fk_id_veiculo int NOT NULL,
  PRIMARY KEY (id_reserva),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario(id_usuario),
  FOREIGN KEY (fk_id_usuario) REFERENCES veiculo(id_veiculo),
  FOREIGN KEY (fk_id_departamento) REFERENCES departamento(id_departamento)
);

INSERT INTO `reserva` (`id_reserva`, `data_saida`, `data_saida_real`, `data_retorno`, `data_retorno_real`, `km_saida`, `km_retorno`, `status_reserva`, `destino`, `condutor`, `motivo`, `fk_id_departamento`, `fk_id_usuario`, `fk_id_veiculo`) VALUES
(1, '2021-06-20 20:54:00', NULL, '2021-06-20 21:54:00', NULL, NULL, NULL, 'A', 'aaaaaa', 'aaaaa', 'aaaaaaa', 1, 1, 1),
(4, '2021-06-21 10:43:00', NULL, '2021-06-21 11:43:00', NULL, NULL, NULL, 'A', 'cccccc', 'cccccccc', 'cccccccc', 1, 1, 2),
(5, '2021-06-21 10:51:00', NULL, '2021-06-21 12:51:00', NULL, NULL, NULL, 'A', 'zzz', 'zzzzzz', 'zzzzz', 1, 2, 1);