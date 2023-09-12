create database pit;
use pit;
CREATE TABLE `coisa` (
  CPF CHAR(14) NOT NULL PRIMARY KEY,
  userName VARCHAR(100) NOT NULL,
  senha VARCHAR(30),
  email VARCHAR(200),
  telefone CHAR(15) NOT NULL,
  cnpj CHAR(18) NOT NULL,
  FOREIGN KEY (cnpj) REFERENCES empresa(cnpj)
);
	
create table `empresa`(
cnpj char(18) not null primary key,
Nome Varchar(100) not null,
senha varchar(30)  not null,
email varchar(200) not null,
telefone char(15) not null,
CEP char(9) not null
);

CREATE TABLE evento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario CHAR(14) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
  data DATE,
    FOREIGN KEY (id_usuario) REFERENCES coisa(CPF)
);


select * from coisa;
select * from empresa;

drop table empresa;
drop table coisa;
drop table evento;



drop table empresa;
drop table coisa;