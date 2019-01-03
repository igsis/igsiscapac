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