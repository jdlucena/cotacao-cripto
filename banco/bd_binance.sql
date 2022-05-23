-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 23-Maio-2022 às 19:15
-- Versão do servidor: 5.7.36
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `binance`
--
DROP DATABASE IF EXISTS `binance`;
CREATE DATABASE IF NOT EXISTS `binance` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `binance`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `price`
--

DROP TABLE IF EXISTS `price`;
CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id do registro',
  `symbol` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'nome da criptomoeda',
  `price` decimal(16,8) NOT NULL COMMENT 'cotacao da criptomoeda',
  `registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data que foi inserido no banco',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tabela que registra as cotacoes das criptomoedas';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
