-- Active: 1771004203608@@127.0.0.1@3306@BNGRC

CREATE DATABASE BNGRC;
USE BNGRC;

CREATE  TABLE Besoin(
    idBesoin INT PRIMARY KEY AUTO_INCREMENT,
    valBesoin VARCHAR(100),
    idType INT
);

CREATE OR REPLACE TABLE Region(
    idRegion INT PRIMARY KEY AUTO_INCREMENT,
    valRegion VARCHAR(100)
);

CREATE  TABLE Ville(
    idVille INT PRIMARY KEY AUTO_INCREMENT,
    idRegion INT,
    valVille VARCHAR(100)
);

CREATE  TABLE Don(
    idDon INT PRIMARY KEY AUTO_INCREMENT,
    dateDon DATE,
    totalPrix DOUBLE
);


CREATE  TABLE Produit(
    idProduit INT PRIMARY KEY AUTO_INCREMENT,
    valProduit VARCHAR(100),
    idType INT
);

CREATE  TABLE EquivalenceProduit(
    idEquivalenceProduit INT PRIMARY KEY AUTO_INCREMENT,
    idProduit INT,
    quantite DOUBLE,
    val VARCHAR(50),
    prix DOUBLE
);

CREATE  TABLE ProduitBesoin(
    idProduitBesoin INT PRIMARY KEY AUTO_INCREMENT,
    idProduit INT,
    idBesoin INT
);
CREATE  TABLE Donnation(
    idDonnation INT PRIMARY KEY AUTO_INCREMENT,
    idDon INT,
    idProduit INT,
    quantiteProduit DECIMAL(10,2)
);


