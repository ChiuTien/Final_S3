-- Script de création et insertion de données pour StatutBesoin et Statut
USE BNGRC;

-- Création des tables
CREATE  TABLE StatutBesoin(
    IdStatutBesoin INT PRIMARY KEY AUTO_INCREMENT,
    ValStatutBesoin VARCHAR(100) NOT NULL
);

CREATE  TABLE Statut(
    IdStatut INT PRIMARY KEY AUTO_INCREMENT,
    IdBesoin INT,
    IdStatutBesoin INT,
    DateDeChangement DATETIME 
);
