-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.31-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela capac.regioes
CREATE TABLE IF NOT EXISTS `regioes` (
                                         `id` int(2) NOT NULL AUTO_INCREMENT,
                                         `regiao` varchar(12) DEFAULT NULL,
                                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela capac.regioes: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `regioes` DISABLE KEYS */;
INSERT INTO `regioes` (`id`, `regiao`) VALUES
(1, 'Centro-Oeste'),
(2, 'Norte'),
(3, 'Sul'),
(4, 'Leste');
/*!40000 ALTER TABLE `regioes` ENABLE KEYS */;

-- Copiando estrutura para tabela capac.formacao_dados_complementares
CREATE TABLE IF NOT EXISTS `formacao_dados_complementares` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `pessoa_fisica_id` int(11) NOT NULL DEFAULT '0',
    `area_atuacao_2` int(2) DEFAULT NULL,
    `area_atuacao_3` int(2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `pessoa_fisica_id` (`pessoa_fisica_id`),
    CONSTRAINT `formacao_pf` FOREIGN KEY (`pessoa_fisica_id`) REFERENCES `pessoa_fisica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela capac.formacao_dados_complementares: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `formacao_dados_complementares` DISABLE KEYS */;
/*!40000 ALTER TABLE `formacao_dados_complementares` ENABLE KEYS */;

ALTER TABLE `pessoa_fisica`
    ADD COLUMN `formacao_regiao_preferencial` INT(2) NULL DEFAULT NULL AFTER `formacao_linguagem_id`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
