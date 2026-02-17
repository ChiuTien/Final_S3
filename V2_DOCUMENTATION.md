# Documentation V2 - Système de Gestion des Achats

## Vue d'ensemble
La V2 ajoute un nouveau système d'achat de produits pour satisfaire les besoins collectés. Elle permet de:
1. Créer des achats (quantité de produit pour un besoin)
2. Calculer automatiquement les frais d'achat
3. Simuler et valider les achats
4. Voir un récapitulatif des acquisitions et des besoins restants

## Architecture

### Modèles
- **Achat** (`app/models/Achat.php`): Représente une transaction d'achat
  - Attributs: idAchat, idBesoin, idProduit, quantiteAchetee, prixUnitaire, montantTotal, montantFrais, montantAvecFrais, dateAchat, statut
  - Statuts: 'simulation', 'validé', 'rejeté'

- **Config** (`app/models/Config.php`): Configuration système
  - Attributs: idConfig, cleCongif, valeur, description

- **Produit** (modifié): Ajout de prixUnitaire pour support de la tarification

### Repositories
- **RepAchat** (`app/repository/RepAchat.php`): Accès aux données des achats
  - addAchat(Achat): int
  - getAchatById(id): ?Achat
  - getAllAchats(statut=null): array
  - updateStatutAchat(id, statut): void
  - deleteAchat(id): void

- **RepConfig** (`app/repository/RepConfig.php`): Accès aux configurations
  - getConfigByKey(cle): ?Config
  - getAllConfig(): array
  - updateConfig(cle, valeur): void
  - getConfigValue(cle, default): mixed

### Contrôleurs
- **ControllerAchat** (`app/controllers/ControllerAchat.php`): Logique métier des achats
- **ControllerConfig** (`app/controllers/ControllerConfig.php`): Gestion des configurations

### Vues
1. **achat.php** (`app/views/achat.php`): Formulaire pour créer un achat
   - Sélection du besoin
   - Sélection du produit avec affichage du prix
   - Saisie de la quantité
   - Calcul dynamique des frais (JavaScript)
   - Liste des achats en simulation

2. **simulation.php** (`app/views/simulation.php`): Révision avant validation
   - Table des achats en simulation
   - Total des achats
   - Boutons: Valider tous / Annuler et revenir

3. **recapitulation.php** (`app/views/recapitulation.php`): Récapitulatif des acquisitions
   - Statistiques globales (total besoins, montant satisfait, restant, % complétion)
   - Barre de progression visuelle
   - Liste des achats validés

## Flux de travail

```
/achat (Formulaire)
  ↓ (POST /achat/acheter)
Achat créé en statut 'simulation'
  ↓ (Lien vers /simulation)
/simulation (Révision)
  ↓ (POST /simulation/valider)
Achats passés en 'validé'
  ↓ (Redirect)
/recapitulation (Vue récapitulatif)
```

Alternative:
```
/simulation
  ↓ (POST /simulation/rejeter)
Achats supprimés
  ↓ (Redirect)
/achat (Retour au formulaire)
```

## Configuration

### Frais d'achat
- Stocké dans la table `Config` avec la clé `frais_achat_pourcentage`
- Par défaut: 10%
- Utilisé lors du calcul: `montantFrais = montantTotal × (fraisAchatPourcentage / 100)`

### Calculs
```
montantTotal = quantiteAchetee × prixUnitaire
montantFrais = montantTotal × (fraisAchatPourcentage / 100)
montantAvecFrais = montantTotal + montantFrais
```

## Migration Base de Données

Exécutez le fichier `/sql/18_02_2026_v2_modifications.sql`:

```sql
-- Ajoute prixUnitaire à la table Produit
ALTER TABLE Produit ADD COLUMN prixUnitaire DECIMAL(10, 2) DEFAULT 0.00;

-- Crée la table Config pour les paramètres système
CREATE TABLE Config (
    idConfig INT PRIMARY KEY AUTO_INCREMENT,
    cleCongif VARCHAR(100) UNIQUE NOT NULL,
    valeur VARCHAR(255) NOT NULL,
    description TEXT
);

-- Crée la table Achat pour tracer les acquisitions
CREATE TABLE Achat (
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
    FOREIGN KEY (idBesoin) REFERENCES Besoin(idBesoin),
    FOREIGN KEY (idProduit) REFERENCES Produit(idProduit)
);

-- Index de performance
CREATE INDEX idx_achat_besoin ON Achat(idBesoin);
CREATE INDEX idx_achat_produit ON Achat(idProduit);
CREATE INDEX idx_achat_statut ON Achat(statut);
CREATE INDEX idx_produit_prix ON Produit(prixUnitaire);
```

## Routes

| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/achat` | Affiche le formulaire d'achat |
| POST | `/achat/acheter` | Crée un nouvel achat en simulation |
| GET | `/simulation` | Affiche les achats en attente de validation |
| POST | `/simulation/valider` | Valide tous les achats en simulation |
| POST | `/simulation/rejeter` | Annule tous les achats en simulation |
| GET | `/recapitulation` | Affiche le récapitulatif et les stats |

## Points d'accès

- Menu Welcome: Trois boutons dans la section "Gestion des Achats (V2)"
  - "Nouveau Achat" → `/achat`
  - "Simulation" → `/simulation`
  - "Récapitulation" → `/recapitulation`

## Compatibilité

- **Backward Compatible**: Aucune modification aux tables ou routes existantes
- **Isolation**: La V2 utilise des tables séparées (Achat, Config)
- **Indépendance**: Les achats sont indépendants des dons/dispatches v1

## Validation et Sécurité

- Vérification des IDs besoin/produit existants
- Vérification du prix unitaire > 0
- Vérification de la quantité > 0
- Calcul des montants côté serveur (sécurité)
- Affichage JSON-safe (htmlspecialchars)
- CSRF protection via SecurityHeadersMiddleware (à configurer)

## Exemple de Flux Complet

1. Utilisateur clique "Nouveau Achat"
2. Page affiche formulaire avec:
   - Besoins disponibles
   - Produits avec prix
3. Utilisateur sélectionne:
   - Besoin: "Nourriture pour réfugiés - 100€"
   - Produit: "Riz - 1.50€/kg"
   - Quantité: "50"
4. JavaScript affiche:
   - Montant: 75€ (50 × 1.50)
   - Frais: 7.50€ (75 × 10%)
   - Total: 82.50€
5. Utilisateur soumet le formulaire
6. Achat créé en Base avec statut "simulation"
7. Utilisateur voit l'achat dans la liste "Achats en Simulation"
8. Utilisateur clique "Voir la Simulation"
9. Page affiche table de révision avec tous les achats
10. Utilisateur clique "Valider tous les achats"
11. Statuts changent à "validé"
12. Redirect vers `/recapitulation`
13. Récapitulation montre:
    - Total besoins: 100€
    - Montant satisfait: 82.50€
    - Montant restant: 17.50€
    - % complétion: 82.5%
    - Table des achats validés

## Maintenance

### Ajouter un nouveau paramètre de configuration:
```php
$config = new Config();
$config->setCleCongif('ma_nouvelle_cle');
$config->setValeur('ma_nouvelle_valeur');
$repConfig->addConfig($config);
```

### Modifier le pourcentage de frais:
```php
$controllerConfig->updateConfig('frais_achat_pourcentage', '15');
```

### Récupérer les achats d'un statut spécifique:
```php
$controllerAchat->getAllAchats('validé'); // Retourne tous les achats validés
```

