-- Active: 1771004203608@@127.0.0.1@3306
CREATE DATABASE BNGRC;
USE BNGRC;

CREATE OR REPLACE TABLE Besoin(
    idBesoin INT PRIMARY KEY AUTO_INCREMENT,
    valBesoin VARCHAR(100),
    idType INT
);

CREATE OR REPLACE TABLE Region(
    idRegion INT PRIMARY KEY AUTO_INCREMENT,
    valRegion VARCHAR(100)
);

CREATE OR REPLACE TABLE Ville(
    idVille INT PRIMARY KEY AUTO_INCREMENT,
    idRegion INT,
    valVille VARCHAR(100)
);

CREATE OR REPLACE TABLE Produit(
    idProduit INT PRIMARY KEY AUTO_INCREMENT,
    valProduit VARCHAR(100),
    idType INT
);

CREATE OR REPLACE TABLE EquivalenceProduit(
    idEquivalenceProduit INT PRIMARY KEY AUTO_INCREMENT,
    idProduit INT,
    quantite DOUBLE,
    prix DOUBLE
);

CREATE OR REPLACE TABLE ProduitBesoin(
    idProduitBesoin INT PRIMARY KEY AUTO_INCREMENT,
    idProduit INT,
    idBesoin INT
);
