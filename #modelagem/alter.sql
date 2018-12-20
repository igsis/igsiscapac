ALTER TABLE `formacao_linguagem` ADD COLUMN `publicado` TINYINT NOT NULL DEFAULT '1' AFTER `tipo_formacao_id`;

ALTER TABLE `formacao_funcoes` ADD COLUMN `publicado` TINYINT NOT NULL DEFAULT '1' AFTER `tipo_formacao_id`;