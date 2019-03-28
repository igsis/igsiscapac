CREATE TABLE `oficina_dados_complementares` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `oficina_id` INT(11) NOT NULL,
  `modalidade_id` INT(11) NOT NULL,
  `dataInicio` DATE NULL DEFAULT NULL,
  `dataFim` DATE NULL DEFAULT NULL,
  `dia1` INT(11) NULL DEFAULT NULL,
  `dia2` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO oficina_dados_complementares (oficina_id, modalidade_id, dataInicio, dataFim, dia1, dia2)
SELECT idOficina, modalidade_id, dataInicio, dataFim, dia1, dia2 FROM oficina_dados WHERE idOficina IS NOT NULL;