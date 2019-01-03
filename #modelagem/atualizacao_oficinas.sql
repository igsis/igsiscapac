USE `capac`;

CREATE TABLE `prefeitura_regionais` (
`id` INT(10) NOT NULL AUTO_INCREMENT,
`prefeituraRegional` VARCHAR(30) NULL DEFAULT NULL,
PRIMARY KEY (`id`)
);

INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (1, 'Aricanduva');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (2, 'Butantã');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (3, 'Campo Limpo');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (4, 'Capela do Socorro');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (5, 'Casa Verde / Cachoeirinha');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (6, 'Cidade Tiradentes');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (7, 'Ermelino Matarazzo');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (8, 'Freguesia do Ó / Brasilândia');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (9, 'Guaianases');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (10, 'Ipiranga');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (11, 'Itaim Paulista');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (12, 'Itaquera');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (13, 'Jabaquara');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (14, 'Jaçanã / Tremembé');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (15, 'Lapa');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (16, 'M''Boi Mirim');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (17, 'Mooca');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (18, 'Parelheiros');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (19, 'Penha');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (20, 'Perus');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (21, 'Pinheiros');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (22, 'Pirituba');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (23, 'Santana / Tucuruvi');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (24, 'Santo Amaro');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (25, 'São Mateus');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (26, 'São Miguel');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (27, 'Sapopemba');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (28, 'Sé');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (29, 'Vila Maria / Vila Guilherme');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (30, 'Vila Mariana');
INSERT INTO capac.prefeitura_regionais (id, prefeituraRegional) VALUES (31, 'Vila Prudente');

ALTER TABLE `pessoa_fisica` ADD COLUMN `prefeituraRegional_id` INT NULL AFTER `complemento`;

CREATE TABLE `oficina_niveis` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`nivel` VARCHAR(15) NOT NULL,
PRIMARY KEY (`id`)
);