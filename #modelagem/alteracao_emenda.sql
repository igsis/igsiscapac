USE capac;

CREATE TABLE `emenda_parlamentar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idEvento` INT NOT NULL,
  `tipoEmenda` TINYINT NOT NULL COMMENT '1- Contratação Artistica; 2- Parcerias',
  `DataEnvio` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

asINSERT INTO `upload_lista_documento` (`id`, `idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES (165, 2, 'Plano de Trabalho', 'planot', 1, 1, 1, 1, NULL, 1);