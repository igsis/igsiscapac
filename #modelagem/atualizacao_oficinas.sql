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
INSERT INTO capac.oficina_linguagens (id, linguagem) VALUES (23, 'Outra');

CREATE TABLE `oficina_dados` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`tipoPessoa` INT(11) NOT NULL,
`idPessoa` INT(11) NOT NULL,
`nomeOficina` VARCHAR(240) NULL DEFAULT NULL,
`oficina_linguagem_id` INT(11) NOT NULL,
`oficina_nivel_id` INT(11) NOT NULL,
`modalidade_id` INT(11) NOT NULL DEFAULT '0',
`publicado` TINYINT(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
);
INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (159, 4, 'Currículo', 'curriculo', 1, 1, 1, 0, null, 1);
INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (160, 5, 'Currículo', 'curriculo', 1, 1, 1, 0, null, 1);

INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (161, 4, 'Comprovante de experiência artístico-pedagógica (no mínimo 2)', 'comartped1', 1, 1, 1, 0, null, 1);
INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (162, 5, 'Comprovante de experiência artístico-pedagógica (no mínimo 2)', 'comartped1', 1, 1, 1, 0, null, 1);
INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (163, 4, 'Comprovante de experiência artística (no mínimo 2)', 'com_art1', 1, 1, 1, 0, null, 1);
INSERT INTO capac.upload_lista_documento (id, idTipoUpload, documento, sigla, teatro, musica, oficina, edital, validade, publicado) VALUES (164, 5, 'Comprovante de experiência artística (no mínimo 2)', 'com_art1', 1, 1, 1, 0, null, 1);

CREATE TABLE `capac`.`oficina_sublinguagens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idLinguagem` INT NOT NULL,
  `sublinguagem` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`id`));

INSERT INTO oficina_sublinguagens (idLinguagem, sublinguagem) VALUES 
(1, "Performance/ Intervenção Urbana"),
(1, "Pintura"),
(1, "Desenho e gravuras"),
(1, "Vídeo mapping"),
(1, "Produção gráfica"),
(2, "Sonoplastia"),
(2, "Sonorização/ Técnico de Som"),
(2, "Produção Musical"),
(3, "Introdução ao audiovisual"),
(3, "Linguagem cinematográfica"),
(3, "Live action/ato real"),
(3, "Animação"),
(3, "Documentário"),
(3, "Curta-metragem - do roteiro à gravação"),
(3, "Fotografia para cinema"),
(3, "Direção de arte para cinema"),
(3, "Roteiro cinematográfico"),
(3, "Interpretação para cinema"),
(3, "Produção de vídeo"),
(4, "Kung fu"),
(4, "Karatê"),
(4, "Jiu-jitsu"),
(4, "Taekwondo"),
(5, "Capoeira Angola"),
(5, "Capoeira Regional"),
(6, "Jongo"),
(6, "Forró"),
(6, "Tambor de crioula"),
(6, "Samba de roda"),
(6, "Culinária"),
(6, "Maracatu"),
(7, "Palhaçaria"),
(7, "Técnicas circenses"),
(7, "Aéreos"),
(7, "Dramaturgia circense"),
(7, "Circo teatro"),
(7, "Ilusionismo e mágica"),
(8, "Balé clássico"),
(8, "Balé contemporâneo"),
(8, "Dança contemporânea"),
(8, "Danças brasileiras e do mundo"),
(8, "Samba rock"),
(8, "Dança de salão"),
(8, "Dança do ventre"),
(8, "Dança para terceira idade"),
(8, "Sapateado"),
(8, "Dança cigana"),
(9, "Criação e elaboração de textos e peças curtas, com ênfase em processos coletivos de criação;"),
(9, "Estudo dos estilos dramatúrgicos,"),
(9, "Oficina teórica e prática que poderá se relacionar com outras mídias como, rádio e TV, websites."),
(10, "Curso relacionado à área de produção que tem como foco a elaboração de projetos artísticos com o intuito de preparar os artistas na confecção de seus projetos e apresentar propostas para editais, e a novos estímulos para a execução de seus processos"),
(11, "Fotografia analógica e digital"),
(11, "Fotografia digital"),
(11, "Fotografia com câmera de celular"),
(11, "Fotografia documental"),
(12, "Confecção e criação em moda"),
(12, "Modelagem e cróquis"),
(12, "Corte e costura"),
(12, "Customização"),
(13, "Quadrinhos"),
(13, "Elaboração de roteiro e desenho para quadrinhos"),
(13, "Mangá"),
(14, "Graffiti"),
(14, "Danças urbanas"),
(14, "Dj"),
(14, "MC"),
(15, "RPG (Role Playing Game)"),
(15, "Xadrez"),
(15, "Jogos de tabuleiro"),
(15, "Streetball"),
(16, "Histórias brincantes"),
(16, "Escrita criativa"),
(16, "Formação para mediadores de leitura"),
(16, "Formação para Contadores de história"),
(17, "Pesquisa e produção artística ou cultural em meios digitais"),
(17, "Desenvolvimento de aplicativos e softwares"),
(17, "Projetos de convergência e interatividade"),
(17, "Novas mídias e espaços digitais de interação social"),
(18, "Canto coral"),
(18, "Canto popular"),
(18, "Flauta doce"),
(18, "Improvisação musical"),
(18, "Musicalização infantil"),
(18, "Percussão"),
(18, "Teclado"),
(18, "Teoria e prática musical"),
(18, "Violão erudito"),
(18, "Violão popular"),
(18, "Violino"),
(18, "Prática de conjunto"),
(19, "Iniciação a linguagem teatral"),
(19, "Teatro infantil"),
(19, "Teatro de máscaras"),
(19, "Teatro de sombras"),
(19, "Teatro de rua"),
(19, "Dramaturgia"),
(19, "Jogos teatrais"),
(19, "Iluminação cênica"),
(19, "Cenotecnia"),
(20, "Lian Gong"),
(20, "Parkour"),
(20, "Yoga"),
(20, "Tai Chi Chuan"),
(21, "Biscuit"),
(21, "Confecção de bonecos"),
(21, "Bordado"),
(21, "Crochê"),
(21, "Amigurumi - crochê 3D"),
(21, "Decoupage"),
(21, "Pintura em Tecido"),
(21, "Tricô"),
(21, "Patch Work"),
(21, "Tear"),
(21, "Origami"),
(22, "Horta comunitária"),
(22, "Bioconstrução"),
(22, "Jardim vertical"),
(23, "Outra");