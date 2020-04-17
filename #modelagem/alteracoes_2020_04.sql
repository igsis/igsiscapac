USE capac;

--
-- Estrutura da tabela `tipo_chamamento`
--

CREATE TABLE `tipo_chamamento` (
   `id` int(11) NOT NULL,
   `chamamento` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tipo_chamamento` (`id`, `chamamento`) VALUES
(1, 'Bibliotecas Online'),
(2, 'Casas de Cultura Online'),
(3, 'Centros Culturais Online'),
(4, 'Teatros Online'),
(5, 'Vivências Online');

ALTER TABLE `tipo_chamamento`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `tipo_chamamento`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Estrutura da tabela `cultura_online`
--

CREATE TABLE `cultura_online` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `tipo_chamamento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `cultura_online`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `cultura_online`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `integrante`
    CHANGE COLUMN `publicado` `publicado` TINYINT(1) NOT NULL DEFAULT '1' AFTER `cpf`;

CREATE TABLE `evento_integrante` (
     `evento_id` INT NOT NULL,
     `integrante_id` INT NOT NULL,
     INDEX `evento_id` (`evento_id`),
     INDEX `integrante_id` (`integrante_id`),
     CONSTRAINT `evento_fk` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
     CONSTRAINT `integrante_fk` FOREIGN KEY (`integrante_id`) REFERENCES `integrante` (`idIntegrante`) ON UPDATE NO ACTION ON DELETE NO ACTION
) COLLATE='utf8mb4_general_ci';

--
-- Estrutura da tabela `co_linguagem`
--

CREATE TABLE `co_linguagem` (
    `id` int(11) NOT NULL,
    `linguagem` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `co_linguagem` (`id`, `linguagem`) VALUES
(1, 'Arte de Rua'),
(2, 'Arte e Cultura Digital'),
(3, 'Artes Visuais'),
(4, 'Artesanato'),
(5, 'Audiovisual, Cinema, Televisão e Novas Mídias'),
(6, 'Batalhas de rimas'),
(7, 'Bate papo com griots e demais mestres das culturas de tradição oral'),
(8, 'Capoeira'),
(9, 'Circo'),
(10, 'Contações de histórias'),
(11, 'Conversa com escritores, rappers e poetas'),
(12, 'Cultura Cigana'),
(13, 'Cultura digital'),
(14, 'Cultura Estrangeira (imigrantes)'),
(15, 'Cultura Geek'),
(16, 'Cultura Indígena'),
(17, 'Cultura LGBTQIA+'),
(18, 'Cultura Negra'),
(19, 'Cultura Popular'),
(20, 'Dança'),
(21, 'Debates literários'),
(22, 'Gastronomia'),
(23, 'Gestão Cultural'),
(24, 'Hip-hop'),
(25, 'Lançamento de livros'),
(26, 'Leituras dramáticas'),
(27, 'Literatura'),
(28, 'Moda'),
(29, 'Música'),
(30, 'Patrimônio Imaterial'),
(31, 'Patrimônio Material'),
(32, 'Produção Cultural'),
(33, 'Rádios comunitárias e podcasts'),
(34, 'Saraus'),
(35, 'Slams'),
(36, 'Teatro');

ALTER TABLE `co_linguagem`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `co_linguagem`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Estrutura da tabela `co_modalidade`
--

CREATE TABLE `co_modalidade` (
                                 `id` int(11) NOT NULL,
                                 `modalidade` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `co_modalidade` (`id`, `modalidade`) VALUES
(1, 'Apresentações artísticas'),
(2, 'Vivências'),
(3, 'Livro, leitura e literatura'),
(4, 'Intervenções artísticas');

ALTER TABLE `co_modalidade`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `co_modalidade`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Estrutura da tabela `co_modalidade_linguagem`
--

CREATE TABLE `co_modalidade_linguagem` (
   `co_modalidade_id` int(11) NOT NULL,
   `co_linguagem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `co_modalidade_linguagem` (`co_modalidade_id`, `co_linguagem_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(1, 9),
(1, 12),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 22),
(1, 28),
(1, 29),
(1, 33),
(1, 36),
(1, 24),
(1, 8),
(2, 4),
(2, 23),
(2, 30),
(2, 31),
(2, 32),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(2, 9),
(2, 12),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 22),
(2, 28),
(2, 29),
(2, 33),
(2, 36),
(2, 24),
(3, 34),
(3, 26),
(3, 21),
(3, 11),
(3, 25),
(3, 10),
(3, 35),
(3, 7),
(4, 1),
(4, 3),
(4, 5),
(4, 9),
(4, 20),
(4, 27),
(4, 29),
(4, 13),
(4, 36);

--
-- Estrutura da tabela `co_pf_complementar`
--

CREATE TABLE `co_pf_complementar` (
  `pessoa_fisica_id` int(11) NOT NULL,
  `estado_civil_id` int(11) NOT NULL,
  `nacionalidade_id` int(11) NOT NULL,
  `curriculo` longtext NOT NULL,
  `rede_social` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `nacionalidades`
--

CREATE TABLE `nacionalidades` (
  `id` smallint(4) NOT NULL,
  `nacionalidade` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nacionalidades` (`id`, `nacionalidade`) VALUES
(1, 'Brasileiro'),
(2, 'Afegão'),
(3, 'Alemão'),
(4, 'Americano'),
(5, 'Angolano'),
(6, 'Antiguano'),
(7, 'Árabe'),
(8, 'Argélia'),
(9, 'Argentino'),
(10, 'Armeno'),
(11, 'Australiano'),
(12, 'Austríaco'),
(13, 'Bahamense'),
(14, 'Bangladesh'),
(15, 'Barbadiano/Barbadens'),
(16, 'Bechuano'),
(17, 'Belga'),
(18, 'Belizenho'),
(19, 'Boliviano'),
(20, 'Britânico'),
(21, 'Camaronense'),
(22, 'Canadense'),
(23, 'Catariano'),
(24, 'Chileno'),
(25, 'Chinês'),
(26, 'Cingalês'),
(27, 'Colombiano'),
(28, 'Comorense'),
(29, 'Costarriquenho'),
(30, 'Croata'),
(31, 'Cubano'),
(32, 'Dinamarquês'),
(33, 'Dominicana'),
(34, 'Dominicano'),
(35, 'Egípcio'),
(36, 'Equatoriano'),
(37, 'Escocês'),
(38, 'Eslovaco'),
(39, 'Esloveno'),
(40, 'Espanhol'),
(41, 'Francês'),
(42, 'Galês'),
(43, 'Ganês'),
(44, 'Granadino'),
(45, 'Grego'),
(46, 'Guatemalteco'),
(47, 'Guianense'),
(48, 'Guianês'),
(49, 'Haitiano'),
(50, 'Holandês'),
(51, 'Hondurenho'),
(52, 'Húngaro'),
(53, 'Iemenita'),
(54, 'Indiano'),
(55, 'Indonésio'),
(56, 'Inglês'),
(57, 'Iraniano'),
(58, 'Iraquiano'),
(59, 'Irlandês'),
(60, 'Israelita'),
(61, 'Italiano'),
(62, 'Jamaicano'),
(63, 'Japonês'),
(64, 'Líbio'),
(65, 'Malaio'),
(66, 'Marfinense'),
(67, 'Marroquino'),
(68, 'Mexicano'),
(69, 'Moçambicano'),
(70, 'Neozelandês'),
(71, 'Nepalês'),
(72, 'Nicaraguense'),
(73, 'Nigeriano'),
(74, 'Norte-coreano/Corean'),
(75, 'Norueguês'),
(76, 'Omanense'),
(77, 'Palestino'),
(78, 'Panamenho'),
(79, 'Paquistanês'),
(80, 'Paraguaio'),
(81, 'Peruano'),
(82, 'Polonês'),
(83, 'Porto-riquenho'),
(84, 'Português'),
(85, 'Queniano'),
(86, 'Romeno'),
(87, 'Ruandês'),
(88, 'Russo'),
(89, 'Salvadorenho'),
(90, 'Santa-lucense'),
(91, 'São-cristovense'),
(92, 'São-vicentino'),
(93, 'Saudita'),
(94, 'Sérvio'),
(95, 'Sírio'),
(96, 'Somali'),
(97, 'Sueco'),
(98, 'Suíço'),
(99, 'Sul-africano'),
(100, 'Sul-coreano/Coreano'),
(101, 'Surinamês'),
(102, 'Tailandês'),
(103, 'Timorense/Maubere'),
(104, 'Trindadense'),
(105, 'Turco'),
(106, 'Ucraniano'),
(107, 'Ugandense'),
(108, 'Uruguaio'),
(109, 'Venezuelano'),
(110, 'Vietnamita'),
(111, 'Zimbabuense');

ALTER TABLE `nacionalidades`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `nacionalidades`
    MODIFY `id` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;