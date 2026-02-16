
-- Sample data
INSERT INTO Region (valRegion) VALUES ('Analamanga'),('Atsinanana'),('Boeny');
INSERT INTO Ville (idRegion, valVille) VALUES (1,'Antananarivo'),(2,'Toamasina'),(3,'Mahajanga');
INSERT INTO Type (valType) VALUES ('Nature'),('Matériaux'),('Argent');
INSERT INTO Produit (valProduit, idType) VALUES ('Riz',1),('Huile',1),('Tôles',2),('Clous',2);

INSERT INTO Besoin (valBesoin, idType) VALUES
('Riz',1),
('Huile',1),
('Tôles',2),
('Riz',1);
    
INSERT INTO Don (dateDon, totalPrix) VALUES
('2026-02-16 10:00:00',200000),
('2026-02-16 09:30:00',50000),
('2026-02-15 14:00:00',1250000);

INSERT INTO Donnation (idDon, idProduit, quantiteProduit) VALUES
(1,1,100),(2,1,50),(3,3,50),(1,2,200);

INSERT INTO Dispatch_mere (id_ville, date_dispatch) VALUES (3,'2026-02-16 10:30:00'),(1,'2026-02-15 09:00:00');
INSERT INTO Dispatch_fille (id_dispatch_mere, id_produit, quantite) VALUES (1,1,250),(1,2,100);

SET FOREIGN_KEY_CHECKS=1;
