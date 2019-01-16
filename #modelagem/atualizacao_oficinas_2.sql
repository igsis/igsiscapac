USE `capac`;

ALTER TABLE `oficina_dados`
  ADD COLUMN `idOficina` INT NULL AFTER `idPessoa`,
  ADD COLUMN `dataInicio` DATE NULL DEFAULT NULL AFTER `modalidade_id`,
  ADD COLUMN `dataFim` DATE NULL DEFAULT NULL AFTER `dataInicio`,
  ADD COLUMN `dia1` INT(2) NULL DEFAULT '0' AFTER `dataFim`,
  ADD COLUMN `dia2` INT(2) NULL DEFAULT '0' AFTER `dia1`;

CREATE TABLE `dia_semanas` (
`id` INT(2) NOT NULL AUTO_INCREMENT,
`dia` VARCHAR(7) NULL DEFAULT '0',
PRIMARY KEY (`id`)
);

INSERT INTO dia_semanas (id, dia) VALUES (1, 'Domingo');
INSERT INTO dia_semanas (id, dia) VALUES (2, 'Segunda');
INSERT INTO dia_semanas (id, dia) VALUES (3, 'Terça');
INSERT INTO dia_semanas (id, dia) VALUES (4, 'Quarta');
INSERT INTO dia_semanas (id, dia) VALUES (5, 'Quinta');
INSERT INTO dia_semanas (id, dia) VALUES (6, 'Sexta');
INSERT INTO dia_semanas (id, dia) VALUES (7, 'Sábado');