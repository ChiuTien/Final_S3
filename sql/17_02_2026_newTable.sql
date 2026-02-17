CREATE OR REPLACE TABLE StatutBesoin(
    IdStatutBesoin INT PRIMARY KEY AUTO_INCREMENT,
    ValStatutBesoin VARCHAR(100) NOT NULL
);


CREATE OR REPLACE TABLE Statut(
    IdStatut INT PRIMARY KEY AUTO_INCREMENT,
    IdBesoin INT,
    IdStatutBesoin INT,
    DateDeChangement DATETIME 
);