USE capac;

CREATE TABLE `emenda_parlamentar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idEvento` INT NOT NULL,
  `tipoEmenda` TINYINT NOT NULL COMMENT '1- Contratação Artistica; 2- Parcerias',
  `DataEnvio` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `upload_lista_documento` CHANGE COLUMN `publicado` `publicado` TINYINT(1) NULL DEFAULT '1' AFTER `validade`;

INSERT INTO `upload_lista_documento` (`id`, `idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES (165, 2, 'Plano de Trabalho', 'planot', 1, 1, 1, 1, NULL, 1);

INSERT INTO `upload_tipo` (`id`, `tipo`) VALUES ('8', 'emenda_parceria');

INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES (8, 'Ofício de Solicitação de Parceria', 'parc_of', 0, 0, 0, 0, NULL, 1);
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES (8, 'Comprovante de Endereço da Instituição Proponente', 'parc_end', 0, 0, 0, 0, NULL, 1);
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Formulário de Abertura de Conta Corrente no Banco do Brasil', 'parc_bb', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Declaração De Inexistência De Débitos Perante A Fazenda SP', 'parc_deb', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Declaração De Não Emprego De Menores', 'parc_men', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Declaração de Ficha Limpa', 'parc_fl', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Declaração De Inexistência De Impedimentos', 'parc_inex', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Declaração de Não Servidor Público', 'parc_serv', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Declaração de Ciência; Carta de Autorização de Abertura de Contas; Inscrição no CNPJ – Receita Federal', 'parc_cnpj', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Contrato Social / Estatuto / Requerimento de Empresário', 'parc_cs', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Cópia da ATA da última reunião de eleição de Diretoria', 'parc_ata1', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Cópia da ATA da última reunião para os demais casos', 'parc_ata2', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Relação nominal atualizada dos dirigentes da entidade', 'parc_diri', '0', '0', '0', '0', NULL, '1');
INSERT INTO `upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `validade`, `publicado`) VALUES ('8', 'Currículo da entidade/empresa', 'parc_curri', '0', '0', '0', '0', NULL, '1');