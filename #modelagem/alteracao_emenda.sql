USE capac;

CREATE TABLE `emenda_parlamentar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idEvento` INT NOT NULL,
  `tipoEmenda` TINYINT NOT NULL COMMENT '1- Contratação Artistica; 2- Parcerias',
  `DataEnvio` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);