CREATE OR REPLACE VIEW DonnationEquivalence AS
(SELECT e.idEquivalenceProduit,e.idProduit,d.idDonnation,d.idDon,d.quantiteProduit,e.quantite,e.prix,e.val
FROM Donnation d JOIN
EquivalenceProduit e ON d.idProduit = e.idProduit);
