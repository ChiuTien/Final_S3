-- Active: 1771004203608@@127.0.0.1@3306
CREATE DATABASE BNGRC;
USER BNGRC;
<<<<<<< HEAD

=======
CREATE OR REPLACE TABLE Besoin(
    idBesoin INT PRIMARY KEY AUTO_INCREMENT,
    idTypeBesoin INT,
    valBesoin VARCHAR(100)
);

CREATE OR REPLACE TABLE EquivalenceBesoin(
    idEquivalenceBesoin INT PRIMARY KEY AUTO_INCREMENT,
    idBesoin INT,
    prixUnitaire DOUBLE,
    quantite DOUBLE,
    val VARCHAR(50)
);
>>>>>>> c4130b192f680741c327091848bb2be49701b830
