CREATE DATABASE BNGRC;
USER BNGRC;
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