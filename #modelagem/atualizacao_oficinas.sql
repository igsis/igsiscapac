USE `capac`;

CREATE TABLE IF NOT EXISTS `prefeitura_regionais` (
`id` INT(10) NOT NULL AUTO_INCREMENT,
`prefeituraRegional` VARCHAR(30) NULL DEFAULT NULL,
PRIMARY KEY (`id`)
);

INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Aricanduva');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Butantã');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Campo Limpo');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Capela do Socorro');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Casa Verde / Cachoeirinha');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Cidade Tiradentes');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Ermelino Matarazzo');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('capacFreguesia do Ó / Brasilândia');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Guaianases');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Ipiranga');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Itaim Paulista');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Itaquera');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Jabaquara');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Jaçanã / Tremembé');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Lapa');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('M''Boi Mirim');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Mooca');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Parelheiros');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Penha');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Perus');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Pinheiros');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Pirituba');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Santana / Tucuruvi');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Santo Amaro');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('São Mateus');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('São Miguel');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Sapopemba');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Sé');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Vila Maria / Vila Guilherme');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Vila Mariana');
INSERT INTO capac.prefeitura_regionais (prefeituraRegional) VALUES ('Vila Prudente');

ALTER TABLE `pessoa_fisica` ADD COLUMN `prefeituraRegional_id` INT NULL AFTER `complemento`;

ALTER TABLE `pessoa_juridica` ADD COLUMN `prefeituraRegional_id` INT NULL AFTER `complemento`;

CREATE TABLE IF NOT EXISTS `oficina_niveis` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`nivel` VARCHAR(15) NOT NULL,
PRIMARY KEY (`id`)
);

INSERT INTO capac.oficina_niveis (id, nivel) VALUES (1, 'Iniciante');
INSERT INTO capac.oficina_niveis (id, nivel) VALUES (2, 'Intermediário');
INSERT INTO capac.oficina_niveis (id, nivel) VALUES (3, 'Avançado');

CREATE TABLE `oficina_linguagens` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`linguagem` VARCHAR(60) NULL DEFAULT NULL,
PRIMARY KEY (`id`)
);

INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (1, 'Artes Visuais');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (2, 'Áudio / Som');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (3, 'Audiovisual');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (4, 'Artes Marciais');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (5, 'Capoeira');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (6, 'Cultura tradicional');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (7, 'Circo');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (8, 'Dança');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (9, 'Dramaturgia');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (10, 'Elaboração de Projetos Culturais / Empreendedorismo Cultural');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (11, 'Fotografia');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (12, 'Figurino');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (13, 'HQs');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (14, 'HIP HOP');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (15, 'Jogos');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (16, 'Literatura');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (17, 'Multimídia');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (18, 'Música');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (19, 'Teatro');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (20, 'Técnicas Corporais');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (21, 'Técnicas Manuais');
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (22, 'Permacultura');

CREATE TABLE `oficina_dados` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`tipoPessoa` INT(11) NOT NULL,
`idPessoa` INT(11) NOT NULL,
`oficina_linguagem_id` INT(11) NOT NULL,
`oficina_nivel_id` INT(11) NOT NULL,
`publicado` TINYINT(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
);

INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (159, 4, 'Currículo', 'curriculo', 1, 1, 1, 0, null, 1);
INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (160, 5, 'Currículo', 'curriculo', 1, 1, 1, 0, null, 1);

