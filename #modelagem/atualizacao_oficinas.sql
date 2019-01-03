ALTER TABLE `formacao_linguagem` ADD COLUMN `publicado` TINYINT NOT NULL DEFAULT '1' AFTER `tipo_formacao_id`;

ALTER TABLE `formacao_funcoes` ADD COLUMN `publicado` TINYINT NOT NULL DEFAULT '1' AFTER `tipo_formacao_id`;

CREATE TABLE `prefeitura_regionais` (
`id` INT(10) NOT NULL AUTO_INCREMENT,
`subprefeitura` VARCHAR(25) NULL DEFAULT NULL,
PRIMARY KEY (`id`)
)