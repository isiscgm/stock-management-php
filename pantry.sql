create database pantry;
use pantry;

drop database pantry;

create table cadastro(
RM int(11) primary key not null,
senha varchar(45) not null, 
email varchar(45) not null,
codigoacessoconta varchar(20) NOT NULL
);

create table produtos(
id int auto_increment primary key,
produto varchar(255) not null,
quantidade INT NOT NULL,
dia DATE NOT NULL,
fornecedor VARCHAR(255) NOT NULL,
unidade varchar(10),
status varchar(45) not null);

create table movimentacoes(
id int auto_increment primary key,
data_movimentacao date not null,
tipo_movimentacao ENUM('entrada','saida') NOT NULL,
produto_id INT NOT NULL,
quantidade INT NOT NULL,
fornecedor VARCHAR(255) NOT NULL,
unidade VARCHAR(10),
FOREIGN KEY (produto_id)
REFERENCES produtos(id)
);

create table historico_baixas(
id int auto_increment primary key,
produto_id int not null,
quantidade int not null,
rm_responsavel varchar(50) not null,
email_responsavel varchar(250) not null,
data_baixa datetime not null,
foreign key (produto_id)
references produtos(id)
);

ALTER TABLE historico_baixas ADD motivo VARCHAR(255) NOT NULL;

