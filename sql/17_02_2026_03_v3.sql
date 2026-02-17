CREATE TABLE OR REPLACE Historique_dispatch (
    idHistorique INT PRIMARY KEY AUTO_INCREMENT,
    idTypeDispatch INT,
    idVille INT,
    idBesoin INT,
    date_change DATE,
    status VARCHAR
);

CREATE TABLE OR REPLACE TypeDispatch (
    idTypeDispatch INT PRIMARY KEY AUTO_INCREMENT,
    nomType VARCHAR
);