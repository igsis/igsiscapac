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