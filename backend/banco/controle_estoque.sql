CREATE DATABASE controle_estoque;
USE controle_estoque;


CREATE TABLE users (
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  firstname VARCHAR(100),
  lastname VARCHAR(100),
  email VARCHAR(150),
  password VARCHAR(100),
  tel VARCHAR(100),
  category VARCHAR(100)
);

CREATE TABLE client (
  id_client INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(150),
  email VARCHAR(150),
  tel VARCHAR(15),
  cpf VARCHAR(50),
  cep VARCHAR(50),
  city VARCHAR(50)
);

CREATE TABLE providers (
  id_provider INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(150),
  email VARCHAR(150),
  tel VARCHAR(15),
  cnpj VARCHAR(50), 
  cep VARCHAR(50),
  city VARCHAR(50)
);

CREATE TABLE products (
  id_product INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  product VARCHAR(150),
  price DECIMAL(30,2),
  amount VARCHAR(300),
  category VARCHAR(150),
  status VARCHAR(100)
);

CREATE TABLE request(
  id_req INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  city VARCHAR(50),
  amount_piece VARCHAR(50),  /*quantos peças foi pedidas*/
  amount_product VARCHAR(50), /* quantos produtos foram */
  number_req VARCHAR(50),
  invoice VARCHAR(100), /*nota fiscal*/
  value_order DECIMAL(30,2),
  status VARCHAR(100)
);

/*CREATE TABLE Adress (
  id_adress,
  cep,
  states,
  city,
  district,
  complement,
  road,
  number_resort,
);*/
