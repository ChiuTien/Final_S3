CREATE TABLE OR REPLACE Historique_dispatch (
    idHistorique INT PRIMARY KEY AUTO_INCREMENT,
    idVille INT,
    idBesoin INT,
    date_change DATE,
    status VARCHAR
);