-- V2 Modifications - 18/02/2026
-- Ajout des colonnes nécessaires pour la V2

-- Ajouter prixUnitaire à la table Produit
ALTER TABLE Produit ADD COLUMN prixUnitaire DECIMAL(10, 2) DEFAULT 0.00 AFTER valProduit;

-- Créer table pour la configuration
CREATE TABLE IF NOT EXISTS Config (
    idConfig INT PRIMARY KEY AUTO_INCREMENT,
    cleCongif VARCHAR(100) UNIQUE NOT NULL,
    valeur VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insérer la configuration par défaut du frais d'achat
INSERT INTO Config (cleCongif, valeur, description) 
VALUES ('frais_achat_pourcentage', '10', 'Pourcentage de frais d\'achat appliqué aux acquisitions');

-- Créer une table pour tracer les achats
CREATE TABLE IF NOT EXISTS Achat (
    idAchat INT PRIMARY KEY AUTO_INCREMENT,
    idBesoin INT NOT NULL,
    idProduit INT NOT NULL,
    quantiteAchetee DECIMAL(10, 2) NOT NULL,
    prixUnitaire DECIMAL(10, 2) NOT NULL,
    montantTotal DECIMAL(12, 2) NOT NULL,
    montantFrais DECIMAL(12, 2) NOT NULL,
    montantAvecFrais DECIMAL(12, 2) NOT NULL,
    dateAchat DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('simulation', 'validé', 'rejeté') DEFAULT 'simulation',
    FOREIGN KEY (idBesoin) REFERENCES Besoin(idBesoin) ON DELETE CASCADE,
    FOREIGN KEY (idProduit) REFERENCES Produit(idProduit) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Index pour améliorer les performances
CREATE INDEX idx_achat_besoin ON Achat(idBesoin);
CREATE INDEX idx_achat_produit ON Achat(idProduit);
CREATE INDEX idx_achat_statut ON Achat(statut);
CREATE INDEX idx_produit_prix ON Produit(prixUnitaire);


