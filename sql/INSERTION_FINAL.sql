-- Insert script generated from provided spreadsheet (2026-02)
-- Assumptions: database `BNGRC` and tables already exist as in project SQL schema.
USE BNGRC;

-- 1) Ensure types
INSERT INTO type(valType)
SELECT 'nature' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM type WHERE valType='nature');
INSERT INTO type(valType)
SELECT 'materiel' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM type WHERE valType='materiel');
INSERT INTO type(valType)
SELECT 'argent' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM type WHERE valType='argent');

-- 2) Ensure villes (no region assigned here)
INSERT INTO Ville(idRegion, valVille)
SELECT NULL, 'Toamasina' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Ville WHERE valVille='Toamasina');
INSERT INTO Ville(idRegion, valVille)
SELECT NULL, 'Mananjary' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Ville WHERE valVille='Mananjary');
INSERT INTO Ville(idRegion, valVille)
SELECT NULL, 'Farafangana' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Ville WHERE valVille='Farafangana');
INSERT INTO Ville(idRegion, valVille)
SELECT NULL, 'Nosy Be' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Ville WHERE valVille='Nosy Be');
INSERT INTO Ville(idRegion, valVille)
SELECT NULL, 'Morondava' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Ville WHERE valVille='Morondava');

-- 3) Ensure produits and their type mapping (use existing Type rows)
INSERT INTO Produit(valProduit, idType)
SELECT 'Riz (kg)', (SELECT idType FROM type WHERE valType='nature' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Riz (kg)');

INSERT INTO Produit(valProduit, idType)
SELECT 'Eau (L)', (SELECT idType FROM type WHERE valType='nature' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Eau (L)');

INSERT INTO Produit(valProduit, idType)
SELECT 'Tôle', (SELECT idType FROM type WHERE valType='materiel' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Tôle');

INSERT INTO Produit(valProduit, idType)
SELECT 'Bâche', (SELECT idType FROM type WHERE valType='materiel' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Bâche');

INSERT INTO Produit(valProduit, idType)
SELECT 'Argent', (SELECT idType FROM type WHERE valType='argent' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Argent');

INSERT INTO Produit(valProduit, idType)
SELECT 'Huile (L)', (SELECT idType FROM type WHERE valType='nature' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Huile (L)');

INSERT INTO Produit(valProduit, idType)
SELECT 'Clous (kg)', (SELECT idType FROM type WHERE valType='materiel' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Clous (kg)');

INSERT INTO Produit(valProduit, idType)
SELECT 'Bois', (SELECT idType FROM type WHERE valType='materiel' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Bois');

INSERT INTO Produit(valProduit, idType)
SELECT 'Haricots', (SELECT idType FROM type WHERE valType='nature' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='Haricots');

INSERT INTO Produit(valProduit, idType)
SELECT 'groupe', (SELECT idType FROM type WHERE valType='materiel' LIMIT 1)
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM Produit WHERE valProduit='groupe');

-- 4) Ensure equivalence / price (quantite = 1 assumed)
INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 3000
FROM Produit p WHERE p.valProduit='Riz (kg)'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=3000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 1000
FROM Produit p WHERE p.valProduit='Eau (L)'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=1000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 25000
FROM Produit p WHERE p.valProduit='Tôle'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=25000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 15000
FROM Produit p WHERE p.valProduit='Bâche'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=15000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 1
FROM Produit p WHERE p.valProduit='Argent'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=1);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 6000
FROM Produit p WHERE p.valProduit='Huile (L)'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=6000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 8000
FROM Produit p WHERE p.valProduit='Clous (kg)'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=8000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 10000
FROM Produit p WHERE p.valProduit='Bois'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=10000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 4000
FROM Produit p WHERE p.valProduit='Haricots'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=4000);

INSERT INTO EquivalenceProduit(idProduit, quantite, prix)
SELECT p.idProduit, 1, 6750000
FROM Produit p WHERE p.valProduit='groupe'
AND NOT EXISTS (SELECT 1 FROM EquivalenceProduit e WHERE e.idProduit=p.idProduit AND e.prix=6750000);

-- 5) Insert donors/donnations rows per spreadsheet row
-- Row: Toamasina | 2026-02-16 | nature | Riz (kg) | 3000 | 800
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Riz (kg)' LIMIT 1), 800);

-- Toamasina | 2026-02-15 | nature | Eau (L) | 1000 | 1500
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Eau (L)' LIMIT 1), 1500);

-- Toamasina | 2026-02-16 | materiel | Tôle | 25000 | 120
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Tôle' LIMIT 1), 120);

-- Toamasina | 2026-02-15 | materiel | Bâche | 15000 | 200
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Bâche' LIMIT 1), 200);

-- Toamasina | 2026-02-16 | argent | Argent | 1 | 12000000
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 12000000);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Argent' LIMIT 1), 12000000);

-- Mananjary | 2026-02-15 | nature | Riz (kg) | 3000 | 500
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Riz (kg)' LIMIT 1), 500);

-- Mananjary | 2026-02-16 | nature | Huile (L) | 6000 | 120
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Huile (L)' LIMIT 1), 120);

-- Mananjary | 2026-02-15 | materiel | Tôle | 25000 | 80
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Tôle' LIMIT 1), 80);

-- Mananjary | 2026-02-16 | materiel | Clous (kg) | 8000 | 60
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Clous (kg)' LIMIT 1), 60);

-- Mananjary | 2026-02-15 | argent | Argent | 1 | 6000000
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 6000000);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Argent' LIMIT 1), 6000000);

-- Farafangana | 2026-02-16 | nature | Riz (kg) | 3000 | 600
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Riz (kg)' LIMIT 1), 600);

-- Farafangana | 2026-02-15 | nature | Eau (L) | 1000 | 1000
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Eau (L)' LIMIT 1), 1000);

-- Farafangana | 2026-02-16 | materiel | Bâche | 15000 | 150
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Bâche' LIMIT 1), 150);

-- Farafangana | 2026-02-15 | materiel | Bois | 10000 | 100
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Bois' LIMIT 1), 100);

-- Farafangana | 2026-02-16 | argent | Argent | 1 | 8000000
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 8000000);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Argent' LIMIT 1), 8000000);

-- Nosy Be | 2026-02-15 | nature | Riz (kg) | 3000 | 300
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Riz (kg)' LIMIT 1), 300);

-- Nosy Be | 2026-02-16 | nature | Haricots | 4000 | 200
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Haricots' LIMIT 1), 200);

-- Nosy Be | 2026-02-15 | materiel | Tôle | 25000 | 40
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Tôle' LIMIT 1), 40);

-- Nosy Be | 2026-02-16 | materiel | Clous (kg) | 8000 | 30
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Clous (kg)' LIMIT 1), 30);

-- Nosy Be | 2026-02-15 | argent | Argent | 1 | 4000000
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 4000000);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Argent' LIMIT 1), 4000000);

-- Morondava | 2026-02-16 | nature | Riz (kg) | 3000 | 700
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Riz (kg)' LIMIT 1), 700);

-- Morondava | 2026-02-15 | nature | Eau (L) | 1000 | 1200
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Eau (L)' LIMIT 1), 1200);

-- Morondava | 2026-02-16 | materiel | Bâche | 15000 | 180
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Bâche' LIMIT 1), 180);

-- Morondava | 2026-02-15 | materiel | Bois | 10000 | 150
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 0);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Bois' LIMIT 1), 150);

-- Morondava | 2026-02-16 | argent | Argent | 1 | 10000000
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-16', 10000000);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='Argent' LIMIT 1), 10000000);

-- Toamasina | 2026-02-15 | materiel | groupe | 6750000 | 3
INSERT INTO Don(dateDon, totalPrix) VALUES ('2026-02-15', 20250000);
SET @don = LAST_INSERT_ID();
INSERT INTO Donnation(idDon, idProduit, quantiteProduit)
VALUES (@don, (SELECT idProduit FROM Produit WHERE valProduit='groupe' LIMIT 1), 3);

-- Optionally: update Don.totalPrix using DonnationEquivalence view if available
-- UPDATE Don d SET totalPrix = (
--   SELECT COALESCE(SUM(dn.quantiteProduit * e.prix / e.quantite),0)
--   FROM Donnation dn JOIN EquivalenceProduit e ON dn.idProduit = e.idProduit
--   WHERE dn.idDon = d.idDon
-- );

-- End of script
