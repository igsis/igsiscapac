// Henrique
CREATE TABLE capac.jovem_monitor (
id INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(80) NOT NULL,
nome_social VARCHAR(80) NULL,
data_nascimento DATE NOT NULL,
rg VARCHAR(45) NOT NULL,
cpf VARCHAR(14) NOT NULL,
endereco_id INT NOT NULL,
PRIMARY KEY (id));

ALTER TABLE capac.jovem_monitor
ADD COLUMN logradouro VARCHAR(80) NOT NULL AFTER cep,
ADD COLUMN numero INT(4) NOT NULL AFTER logradouro,
ADD COLUMN complemento VARCHAR(45) NULL AFTER numero,
ADD COLUMN bairro VARCHAR(80) NOT NULL AFTER complemento,
ADD COLUMN cidade VARCHAR(45) NOT NULL AFTER bairro,
ADD COLUMN estado VARCHAR(2) NOT NULL AFTER cidade,
CHANGE COLUMN endereco_id cep VARCHAR(9) NOT NULL ;

ALTER TABLE capac.jovem_monitor
ADD COLUMN user_id INT NOT NULL AFTER estado;

ALTER TABLE capac.jovem_monitor
ADD COLUMN telefone VARCHAR(15) NOT NULL AFTER cpf;

// Maria

INSERT INTO `capac`.`upload_tipo` (`id`, `tipo`) VALUES ('7', 'jovem_monitor');
INSERT INTO `capac`.`upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `publicado`) VALUES ('7', 'Fotocópia da carteira de identidade', 'rg_arquivo', '0', '0', '0', '0', '1');
INSERT INTO `capac`.`upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `publicado`) VALUES ('7', 'Fotocópia do registro no cadastro de pessoa física', 'cpf_arquivo', '0', '0', '0', '0', '1');
INSERT INTO `capac`.`upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `publicado`) VALUES ('7', 'Fotocópia de Comprovante de Residência recente', 'residencia', '0', '0', '0', '0', '1');
INSERT INTO `capac`.`upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `publicado`) VALUES ('7', 'Currículo Vitae atualizado', 'curriculo_atual', '0', '0', '0', '0', '1');
INSERT INTO `capac`.`upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `publicado`) VALUES ('7', 'Fotocópia do Comprovante de conclusão de ensino médio', 'comprovante', '0', '0', '0', '0', '1');
INSERT INTO `capac`.`upload_lista_documento` (`idTipoUpload`, `documento`, `sigla`, `teatro`, `musica`, `oficina`, `edital`, `publicado`) VALUES ('7', 'Fotocópia dos comprovantes de eventuais participações', 'participacao', '0', '0', '0', '0', '1');

