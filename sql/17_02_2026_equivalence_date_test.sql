-- Données de test pour la table Equivalence_date
-- Vide la table et réinitialise l'auto-increment, puis insère des lignes de test

DELETE FROM Equivalence_date;
ALTER TABLE Equivalence_date AUTO_INCREMENT = 1;

INSERT INTO Equivalence_date (id_besoin, date_equivalence) VALUES
(1, '2026-02-10'),
(2, '2026-02-11'),
(3, '2026-02-12'),
(4, '2026-02-13'),
(5, '2026-02-14'),
(6, '2026-02-15'),
(7, '2026-02-16'),
(8, '2026-02-17');

-- Vérification rapide
SELECT * FROM Equivalence_date ORDER BY idEquivalence;
