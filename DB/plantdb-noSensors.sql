-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 17-Maio-2024 às 15:51
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `plantdb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `id_grupo` int NOT NULL AUTO_INCREMENT,
  `grupo` varchar(30) NOT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `grupo`) VALUES
(0, 'Topo Norte'),
(1, 'Topo Sul'),
(2, 'Topo Oeste'),
(3, 'Topo Este'),
(4, 'Baixo Norte'),
(5, 'Baixo Sul'),
(6, 'Baixo Oeste'),
(7, 'Baixo Este'),
(8, 'Centro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `hora`
--

DROP TABLE IF EXISTS `hora`;
CREATE TABLE IF NOT EXISTS `hora` (
  `id_hora` int NOT NULL AUTO_INCREMENT,
  `periodo_geracao` varchar(10) NOT NULL,
  `sensores` varchar(100) NOT NULL,
  `tipo_geracao` tinyint(1) NOT NULL,
  `num_ficheiros` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_hora`)
) ENGINE=InnoDB AUTO_INCREMENT=999928 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `hora`
--

INSERT INTO `hora` (`id_hora`, `periodo_geracao`, `sensores`, `tipo_geracao`, `num_ficheiros`) VALUES
(171282, 'MINUTE', '0101,0141,0142,0143', 1, 0),
(791454, 'MINUTE', '0101,0141,0142,0143', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int NOT NULL AUTO_INCREMENT,
  `location_x` int NOT NULL,
  `location_y` int NOT NULL,
  `id_sensor` varchar(4) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `grupo` int NOT NULL,
  `gerar` int NOT NULL,
  `size_x` float NOT NULL,
  `size_y` float NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `grupo` (`grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `location`
--

INSERT INTO `location` (`location_id`, `location_x`, `location_y`, `id_sensor`, `status`, `grupo`, `gerar`, `size_x`, `size_y`) VALUES
(1, 183, 341, '0101', 1, 0, 0, 1317, 933),
(2, 422, 313, '0102', 1, 1, 0, 1317, 933),
(3, 549, 312, '0103', 1, 1, 0, 1317, 933),
(4, 677, 312, '0104', 1, 1, 1, 1317, 933),
(5, 803, 315, '0105', 1, 2, 0, 1317, 933),
(6, 928, 311, '0106', 1, 2, 0, 1317, 933),
(7, 362, 364, '0107', 1, 1, 1, 1317, 933),
(8, 487, 365, '0108', 1, 1, 1, 1317, 933),
(9, 615, 363, '0109', 1, 1, 0, 1317, 933),
(10, 740, 363, '0110', 1, 2, 0, 1317, 933),
(11, 866, 362, '0111', 0, 2, 0, 1317, 933),
(12, 297, 439, '0112', 0, 3, 0, 1317, 933),
(13, 423, 436, '0113', 0, 3, 0, 1317, 933),
(14, 550, 438, '0114', 0, 3, 0, 1317, 933),
(15, 676, 438, '0115', 0, 0, 0, 1317, 933),
(16, 741, 200, '0116', 1, 0, 0, 0, 0),
(17, 308, 200, '0117', 0, 3, 0, 0, 0),
(18, 450, 200, '0118', 0, 4, 0, 0, 0),
(19, 271, 267, '0119', 0, 4, 0, 0, 0),
(20, 416, 267, '0120', 1, 4, 0, 0, 0),
(21, 161, 394, '0121', 0, 6, 0, 0, 0),
(22, 305, 535, '0122', 0, 6, 0, 0, 0),
(23, 198, 322, '0123', 0, 6, 0, 0, 0),
(24, 344, 322, '0124', 0, 6, 0, 0, 0),
(25, 489, 322, '0125', 0, 5, 0, 0, 0),
(26, 633, 322, '0126', 0, 5, 0, 0, 0),
(27, 306, 394, '0127', 0, 5, 0, 0, 0),
(28, 452, 393, '0128', 0, 5, 0, 0, 0),
(29, 260, 461, '0129', 1, 7, 0, 0, 0),
(30, 466, 491, '0130', 1, 7, 0, 0, 0),
(31, 452, 481, '0131', 0, 7, 0, 0, 0),
(32, 523, 480, '0132', 0, 7, 0, 0, 0),
(33, 379, 536, '0133', 0, 7, 0, 0, 0),
(34, 525, 535, '0134', 0, 7, 0, 0, 0),
(35, 1061, 327, '0135', 1, 8, 0, 0, 0),
(36, 1191, 326, '0136', 0, 8, 0, 0, 0),
(37, 1094, 390, '0137', 0, 8, 0, 0, 0),
(38, 1160, 420, '0138', 1, 8, 0, 0, 0),
(39, 1061, 485, '0139', 0, 8, 0, 0, 0),
(40, 1187, 485, '0140', 1, 8, 0, 0, 0),
(41, 662, 116, '0141', 0, 0, 0, 0, 0),
(42, 693, 203, '0142', 1, 0, 0, 0, 0),
(43, 803, 116, '0143', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sensors`
--

DROP TABLE IF EXISTS `sensors`;
CREATE TABLE IF NOT EXISTS `sensors` (
  `sensor_id` int NOT NULL AUTO_INCREMENT,
  `id_sensor` varchar(4) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `SetPoint` varchar(3) NOT NULL,
  `DeltaSetPoint` varchar(3) NOT NULL,
  `AddressCold` varchar(3) NOT NULL,
  `AddressHot` varchar(3) NOT NULL,
  `SlaveReply` varchar(4) NOT NULL,
  `SlaveComand` varchar(4) NOT NULL,
  `Command1` varchar(3) NOT NULL,
  `Command2` varchar(3) NOT NULL,
  `Command3` varchar(3) NOT NULL,
  `Command4` varchar(3) NOT NULL,
  `temperature` varchar(10) DEFAULT NULL,
  `humidity` varchar(10) DEFAULT NULL,
  `pressure` varchar(10) DEFAULT NULL,
  `altitude` varchar(10) DEFAULT NULL,
  `eCO2` varchar(10) NOT NULL,
  `eTVOC` varchar(10) NOT NULL,
  `CommunicationStatus` varchar(2) NOT NULL,
  `F_Mount` varchar(3) NOT NULL,
  `F_Open` varchar(3) NOT NULL,
  `F_Lseek` varchar(3) NOT NULL,
  `F_write` varchar(3) NOT NULL,
  `F_Close` varchar(3) NOT NULL,
  `F_Dismount` varchar(4) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`sensor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3189516 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `site_settings`
--

INSERT INTO `site_settings` (`id`, `nome`, `valor`) VALUES
(1, 'site_title', 'Cartonagem Trindade'),
(2, 'cloud_radius', '35'),
(3, 'cloud_radius', '60'),
(4, 'cloud_radius', '60'),
(5, 'cloud_radius', '60'),
(6, 'cloud_radius', '60'),
(7, 'cloud_radius', '60'),
(8, 'cloud_radius', '60'),
(9, 'cloud_radius', '60'),
(10, 'cloud_radius', '60'),
(11, 'cloud_radius', '60'),
(12, 'cloud_radius', '60'),
(13, 'cloud_radius', '60'),
(14, 'cloud_radius', '60'),
(15, 'cloud_radius', '60'),
(16, 'cloud_radius', '200'),
(17, 'cloud_radius', '35'),
(18, 'cloud_radius', '200'),
(19, 'cloud_radius', '35'),
(20, 'site_title', 'WWWWWWWWWWWWWWWWWWWWWWWWWWWWWW'),
(21, 'site_title', 'Cartonagem Trindade Fábrica 10'),
(22, 'site_title', 'CARTONAGEM TRINDADE FÁBRICA 10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(300) NOT NULL,
  `user_type` int NOT NULL,
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `user_type`, `token`) VALUES
(2, 'ciisp', 'ciisp@ispgaya.pt', '8ae624bc8248231584e687b10ce3ec9b42d109d3', 1, ''),
(3, 'cartonagem', 'cartonagem@cartonagem.pt', '8ae624bc8248231584e687b10ce3ec9b42d109d3', 0, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
