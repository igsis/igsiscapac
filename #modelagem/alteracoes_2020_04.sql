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

