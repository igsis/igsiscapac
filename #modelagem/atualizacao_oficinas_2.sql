USE `capac`;

ALTER TABLE `oficina_dados`
  ADD COLUMN `idOficina` INT NULL AFTER `idPessoa`,
  ADD COLUMN `dataInicio` DATE NULL DEFAULT NULL AFTER `modalidade_id`,
  ADD COLUMN `dataFim` DATE NULL DEFAULT NULL AFTER `dataInicio`;

