-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.38-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para ballroom_wagneraugusto
CREATE DATABASE IF NOT EXISTS `ballroom_wagneraugusto` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ballroom_wagneraugusto`;

-- Copiando estrutura para tabela ballroom_wagneraugusto.tb_provider_bank
CREATE TABLE IF NOT EXISTS `tb_provider_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_provider_login` int(11) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `agency` int(11) NOT NULL,
  `account` int(11) NOT NULL,
  `account_digit` int(11) NOT NULL,
  `type_account` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`),
  KEY `tb_bank_fk_tb_provider_data` (`id_provider_login`) USING BTREE,
  CONSTRAINT `tb_bank_fk_tb_provider_login` FOREIGN KEY (`id_provider_login`) REFERENCES `tb_provider_login` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela ballroom_wagneraugusto.tb_provider_bank: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_provider_bank` DISABLE KEYS */;
INSERT INTO `tb_provider_bank` (`id`, `id_provider_login`, `bank`, `agency`, `account`, `account_digit`, `type_account`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 12, 'Itau', 1234, 4321, 100, 'corrente', '2022-03-04 05:53:35', NULL, '2022-03-04 05:03:28'),
	(2, 12, 'Itau', 1234, 43212, 100, 'corrente', '2022-03-04 05:53:43', NULL, NULL);
/*!40000 ALTER TABLE `tb_provider_bank` ENABLE KEYS */;

-- Copiando estrutura para tabela ballroom_wagneraugusto.tb_provider_data
CREATE TABLE IF NOT EXISTS `tb_provider_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_provider_login` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `document` varchar(18) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document` (`document`),
  KEY `tb_provider_data_fk_tb_provider_login` (`id_provider_login`),
  CONSTRAINT `tb_provider_data_fk_tb_provider_login` FOREIGN KEY (`id_provider_login`) REFERENCES `tb_provider_login` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Tabela que realiza a gestão dos fornecedores do sistema ballroom\r\n';

-- Copiando dados para a tabela ballroom_wagneraugusto.tb_provider_data: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_provider_data` DISABLE KEYS */;
INSERT INTO `tb_provider_data` (`id`, `id_provider_login`, `name`, `description`, `document`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, 12, 'Wagner Augusto Mendes dos Santos', 'Desenvolvedor de Software', '41819644855', '2022-03-04 01:49:35', '2022-03-04 01:49:35', '2022-03-04 05:03:35'),
	(3, 13, 'Wagner Augusto Mendes dos Santos', 'Desenvolvedor de Software', '41819644823', '2022-03-04 01:38:01', '2022-03-04 01:38:01', NULL);
/*!40000 ALTER TABLE `tb_provider_data` ENABLE KEYS */;

-- Copiando estrutura para tabela ballroom_wagneraugusto.tb_provider_login
CREATE TABLE IF NOT EXISTS `tb_provider_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela ballroom_wagneraugusto.tb_provider_login: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tb_provider_login` DISABLE KEYS */;
INSERT INTO `tb_provider_login` (`id`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(12, 'wagner1107@Hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2022-03-04 05:29:48', '2022-03-04 01:29:48', NULL),
	(13, 'wagner1107@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2022-03-04 05:30:03', '2022-03-04 01:30:16', '2022-03-04 05:03:16'),
	(14, 'wagner12107@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2022-03-04 14:59:25', '2022-03-04 10:59:25', NULL);
/*!40000 ALTER TABLE `tb_provider_login` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
