-- Données de test pour le projet final S3 - février 2026
-- Système de gestion des dons pour sinistrés (BNGRC)

-- Vider les tables pour repartir à zéro
DELETE FROM Donnation;
DELETE FROM Don;
DELETE FROM ProduitBesoin;
DELETE FROM Besoin;
DELETE FROM EquivalenceProduit;
DELETE FROM Produit;
DELETE FROM Type;
DELETE FROM Ville;
DELETE FROM Region;

-- Réinitialiser les auto-increment
ALTER TABLE Donnation AUTO_INCREMENT = 1;
ALTER TABLE Don AUTO_INCREMENT = 1;
ALTER TABLE ProduitBesoin AUTO_INCREMENT = 1;
ALTER TABLE Besoin AUTO_INCREMENT = 1;
ALTER TABLE EquivalenceProduit AUTO_INCREMENT = 1;
ALTER TABLE Produit AUTO_INCREMENT = 1;
ALTER TABLE Type AUTO_INCREMENT = 1;
ALTER TABLE Ville AUTO_INCREMENT = 1;
ALTER TABLE Region AUTO_INCREMENT = 1;

-- =====================================================
-- RÉGIONS
-- =====================================================
INSERT INTO Region (valRegion) VALUES
('Analamanga'),
('Vakinankaratra'),
('Itasy'),
('Bongolava'),
('Diana'),
('Sava');

-- =====================================================
-- VILLES
-- =====================================================
INSERT INTO Ville (idRegion, valVille) VALUES
-- Analamanga
(1, 'Antananarivo'),
(1, 'Ambohimangakely'),
(1, 'Ankazobe'),

-- Vakinankaratra
(2, 'Antsirabe'),
(2, 'Betafo'),
(2, 'Ambatolampy'),

-- Itasy
(3, 'Miarinarivo'),
(3, 'Arivonimamo'),

-- Bongolava
(4, 'Tsiroanomandidy'),

-- Diana
(5, 'Antsiranana'),
(5, 'Ambanja'),

-- Sava
(6, 'Sambava'),
(6, 'Antalaha');

-- =====================================================
-- TYPES DE BESOINS
-- =====================================================
INSERT INTO Type (valType) VALUES
('nature'),      -- riz, huile, eau, etc.
('materiaux'),   -- tôles, clous, planches, etc.
('argent');      -- aide financière

-- =====================================================
-- PRODUITS (avec unités)
-- =====================================================
-- Produits de nature (nourriture et eau)
INSERT INTO Produit (idType, valProduit) VALUES
(1, 'Riz (kg)'),
(1, 'Huile (litre)'),
(1, 'Eau minérale (litre)'),
(1, 'Sucre (kg)'),
(1, 'Sel (kg)'),
(1, 'Farine (kg)'),

-- Produits matériaux
(2, 'Tôles (unité)'),
(2, 'Clous (kg)'),
(2, 'Planches (unité)'),
(2, 'Ciment (sac 50kg)'),
(2, 'Fer à béton (barre)'),
(2, 'Bâches (m²)'),

-- Argent
(3, 'Don en argent (Ar)');

-- =====================================================
-- ÉQUIVALENCES PRODUITS (prix unitaire et quantité de référence)
-- =====================================================
-- Le prix est basé sur une quantité de référence
-- Exemple: 1 kg de riz coûte 3000 Ar
INSERT INTO EquivalenceProduit (idProduit, quantite, prix) VALUES
-- Nature
(1, 1, 3000),      -- 1 kg riz = 3000 Ar
(2, 1, 8000),      -- 1 litre huile = 8000 Ar
(3, 1, 1500),      -- 1 litre eau = 1500 Ar
(4, 1, 4000),      -- 1 kg sucre = 4000 Ar
(5, 1, 1000),      -- 1 kg sel = 1000 Ar
(6, 1, 3500),      -- 1 kg farine = 3500 Ar

-- Matériaux
(7, 1, 25000),     -- 1 tôle = 25000 Ar
(8, 1, 12000),     -- 1 kg clous = 12000 Ar
(9, 1, 15000),     -- 1 planche = 15000 Ar
(10, 1, 35000),    -- 1 sac ciment = 35000 Ar
(11, 1, 18000),    -- 1 barre fer = 18000 Ar
(12, 1, 10000),    -- 1 m² bâche = 10000 Ar

-- Argent
(13, 1, 1);        -- 1 Ar = 1 Ar (équivalence directe)

-- =====================================================
-- BESOINS (Types de besoins génériques)
-- =====================================================
INSERT INTO Besoin (valBesoin, idType) VALUES
-- Besoins de nature
('Riz', 1),
('Huile', 1),
('Eau', 1),
('Nourriture', 1),

-- Besoins matériaux
('Tôles', 2),
('Matériaux de construction', 2),
('Réparation habitation', 2),

-- Besoins en argent
('Aide financière', 3);

-- =====================================================
-- PRODUITS PAR BESOIN (quantités nécessaires)
-- =====================================================
-- Besoin 1: Riz - nécessite plusieurs produits
INSERT INTO ProduitBesoin (idBesoin, idProduit) VALUES
(1, 1),    -- Riz nécessite Riz (kg)
(2, 2),    -- Huile nécessite Huile (litre)
(3, 3),    -- Eau nécessite Eau minérale
(4, 1),    -- Nourriture nécessite Riz
(4, 2),    -- Nourriture nécessite Huile
(4, 4),    -- Nourriture nécessite Sucre
(4, 5),    -- Nourriture nécessite Sel
(4, 6),    -- Nourriture nécessite Farine

-- Besoins matériaux
(5, 7),    -- Tôles nécessite Tôles (unité)
(5, 8),    -- Tôles nécessite Clous
(6, 7),    -- Matériaux de construction nécessite Tôles
(6, 9),    -- Matériaux de construction nécessite Planches
(6, 10),   -- Matériaux de construction nécessite Ciment
(6, 11),   -- Matériaux de construction nécessite Fer à béton
(7, 7),    -- Réparation habitation nécessite Tôles
(7, 8),    -- Réparation habitation nécessite Clous
(7, 9),    -- Réparation habitation nécessite Planches
(7, 12),   -- Réparation habitation nécessite Bâches

-- Besoin en argent
(8, 13);   -- Aide financière nécessite Don en argent

-- =====================================================
-- DONS REÇUS
-- =====================================================
-- Don 1: 16 février 2026 - Don alimentaire
INSERT INTO Don (dateDon, totalPrix) VALUES
('2026-02-16', 0);  -- Le prix sera calculé automatiquement

SET @don1 = LAST_INSERT_ID();

INSERT INTO Donnation (idDon, idProduit, quantiteProduit) VALUES
(@don1, 1, 100),    -- 100 kg riz
(@don1, 2, 20);     -- 20 litres huile

-- Don 2: 15 février 2026 - Don matériaux
INSERT INTO Don (dateDon, totalPrix) VALUES
('2026-02-15', 0);

SET @don2 = LAST_INSERT_ID();

INSERT INTO Donnation (idDon, idProduit, quantiteProduit) VALUES
(@don2, 7, 50),     -- 50 tôles
(@don2, 8, 10),     -- 10 kg clous
(@don2, 9, 30);     -- 30 planches

-- Don 3: 14 février 2026 - Don mixte
INSERT INTO Don (dateDon, totalPrix) VALUES
('2026-02-14', 0);

SET @don3 = LAST_INSERT_ID();

INSERT INTO Donnation (idDon, idProduit, quantiteProduit) VALUES
(@don3, 1, 200),    -- 200 kg riz
(@don3, 3, 150),    -- 150 litres eau
(@don3, 7, 30),     -- 30 tôles
(@don3, 10, 20);    -- 20 sacs ciment

-- Don 4: 13 février 2026 - Don en argent
INSERT INTO Don (dateDon, totalPrix) VALUES
('2026-02-13', 0);

SET @don4 = LAST_INSERT_ID();

INSERT INTO Donnation (idDon, idProduit, quantiteProduit) VALUES
(@don4, 13, 5000000);  -- 5 000 000 Ar

-- Don 5: 12 février 2026 - Grand don alimentaire
INSERT INTO Don (dateDon, totalPrix) VALUES
('2026-02-12', 0);

SET @don5 = LAST_INSERT_ID();

INSERT INTO Donnation (idDon, idProduit, quantiteProduit) VALUES
(@don5, 1, 500),    -- 500 kg riz
(@don5, 2, 100),    -- 100 litres huile
(@don5, 3, 300),    -- 300 litres eau
(@don5, 4, 150),    -- 150 kg sucre
(@don5, 5, 50);     -- 50 kg sel

-- =====================================================
-- MISE À JOUR DES PRIX TOTAUX DES DONS
-- =====================================================
-- Les prix sont calculés à partir de la vue DonnationEquivalence
UPDATE Don d
SET totalPrix = (
    SELECT COALESCE(SUM(quantiteProduit * prix / quantite), 0)
    FROM DonnationEquivalence
    WHERE idDon = d.idDon
);

-- =====================================================
-- VÉRIFICATIONS
-- =====================================================
-- Afficher les dons avec leur prix total
SELECT 
    d.idDon,
    d.dateDon,
    d.totalPrix as 'Prix Total (Ar)',
    COUNT(dn.idDonnation) as 'Nb Produits'
FROM Don d
LEFT JOIN Donnation dn ON d.idDon = dn.idDon
GROUP BY d.idDon
ORDER BY d.dateDon DESC;

-- Afficher les besoins par type
SELECT 
    t.valType as 'Type',
    b.valBesoin as 'Besoin',
    COUNT(pb.idProduitBesoin) as 'Nb Produits Nécessaires'
FROM Besoin b
JOIN Type t ON b.idType = t.idType
LEFT JOIN ProduitBesoin pb ON b.idBesoin = pb.idBesoin
GROUP BY b.idBesoin
ORDER BY t.idType, b.idBesoin;
