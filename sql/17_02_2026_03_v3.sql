CREATE TABLE OR REPLACE Historique_dispatch (
    idHistorique INT PRIMARY KEY AUTO_INCREMENT,
    idTypeDispatch INT,
    idVille INT,
    idBesoin INT,
    date_change DATE,
    status VARCHAR(255)
);

CREATE TABLE OR REPLACE TypeDispatch (
    idTypeDispatch INT PRIMARY KEY AUTO_INCREMENT,
    nomType VARCHAR(255)
);

INSERT INTO TypeDispatch (nomType) VALUES ('Date'), ('Proportion'), ('Minimum');