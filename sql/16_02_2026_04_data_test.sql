USE BNGRC;

-- Insertion de Types
INSERT INTO Type(valType) VALUES 
('Alimentation'),
('Matériel'),
('Hygiène');

-- Insertion de Produits
INSERT INTO Produit(valProduit, idType) VALUES
('Riz', 1),
('Huile', 1),
('Tôles', 2),
('Eau', 1),
('Savon', 3);

-- Insertion d'équivalences de produits
-- Pour le Riz (idProduit = 1)
INSERT INTO EquivalenceProduit(idProduit, quantite, val, prix) VALUES
(1, 1, 'kg', 3000),      -- 1 kg de riz = 3000 Ar
(1, 25, 'sac', 65000);   -- 1 sac de 25kg = 65000 Ar

-- Pour l'Huile (idProduit = 2)
INSERT INTO EquivalenceProduit(idProduit, quantite, val, prix) VALUES
(2, 1, 'litre', 8000),    -- 1 litre d'huile = 8000 Ar
(2, 5, 'bidon', 38000);   -- 1 bidon de 5L = 38000 Ar

-- Pour les Tôles (idProduit = 3)
INSERT INTO EquivalenceProduit(idProduit, quantite, val, prix) VALUES
(3, 1, 'unité', 45000);   -- 1 tôle = 45000 Ar

-- Pour l'Eau (idProduit = 4)
INSERT INTO EquivalenceProduit(idProduit, quantite, val, prix) VALUES
(4, 1, 'litre', 500),     -- 1 litre d'eau = 500 Ar
(4, 5, 'pack', 2000);     -- 1 pack de 5L = 2000 Ar

-- Pour le Savon (idProduit = 5)
INSERT INTO EquivalenceProduit(idProduit, quantite, val, prix) VALUES
(5, 1, 'unité', 1500),    -- 1 savon = 1500 Ar
(5, 10, 'lot', 12000);    -- 1 lot de 10 = 12000 Ar

-- Insertion de Régions
INSERT INTO Region(valRegion) VALUES
('Analamanga'),
('Vakinankaratra'),
('Itasy');

-- Insertion de Villes
INSERT INTO Ville(idRegion, valVille) VALUES
(1, 'Antananarivo'),
(1, 'Ambohidratrimo'),
(2, 'Antsirabe'),
(3, 'Arivonimamo');

-- Insertion de Besoins
INSERT INTO Besoin(valBesoin, idType) VALUES
('Nourriture urgente', 1),
('Reconstruction maison', 2),
('Kits hygiène', 3);

-- Insertion de ProduitBesoin
INSERT INTO ProduitBesoin(idProduit, idBesoin) VALUES
(1, 1), -- Riz pour nourriture
(2, 1), -- Huile pour nourriture
(4, 1), -- Eau pour nourriture
(3, 2), -- Tôles pour reconstruction
(5, 3); -- Savon pour hygiène
