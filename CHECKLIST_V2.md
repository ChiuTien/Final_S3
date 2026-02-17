# Checklist de Finalisation V2

## ✅ Tâches Complétées

### Infrastructure Backend
- [x] Modèles créés
  - [x] `app/models/Achat.php` - Domaine pour transactions d'achat
  - [x] `app/models/Config.php` - Configuration système
  - [x] `app/models/Produit.php` - Enrichi avec `prixUnitaire`

- [x] Repositories créés/modifiés
  - [x] `app/repository/RepAchat.php` - 5 méthodes CRUD + filtrage
  - [x] `app/repository/RepConfig.php` - 4 méthodes de configuration
  - [x] `app/repository/RepProduit.php` - Modifié pour hydrater prixUnitaire

- [x] Contrôleurs créés
  - [x] `app/controllers/ControllerAchat.php` - Logique métier (7 méthodes)
  - [x] `app/controllers/ControllerConfig.php` - Gestion config (5 méthodes)

- [x] Routes V2 implémentées
  - [x] `GET /achat` - Formulaire d'achat
  - [x] `POST /achat/acheter` - Création avec calcul frais
  - [x] `GET /simulation` - Révision avant validation
  - [x] `POST /simulation/valider` - Valide tous les achats
  - [x] `POST /simulation/rejeter` - Annule la simulation
  - [x] `GET /recapitulation` - Statistiques et récapitulatif

### Interface Utilisateur
- [x] `app/views/achat.php` - Formulaire avec calcul dynamique JavaScript
- [x] `app/views/simulation.php` - Table de révision + boutons action
- [x] `app/views/recapitulation.php` - Stats + progression + liste validés
- [x] Section V2 ajoutée à `welcome.php` avec 3 boutons

### Base de Données
- [x] `sql/18_02_2026_v2_modifications.sql` - Migration prête à exécuter

### Documentation
- [x] `V2_DOCUMENTATION.md` - Documentation complète

---

## 🔄 Tâches Restantes (À Exécuter)

### 1. Exécuter la Migration Base de Données

**Commande:**
```bash
mysql -u [user] -p[password] [database_name] < sql/18_02_2026_v2_modifications.sql
```

**Ou via phpMyAdmin:**
1. Aller dans l'onglet "SQL"
2. Copier le contenu de `/sql/18_02_2026_v2_modifications.sql`
3. Exécuter

**Vérification (après exécution):**
```sql
-- Vérifier que prixUnitaire a été ajouté
DESCRIBE Produit;
-- Résultat: Column "prixUnitaire" should exist, type DECIMAL(10,2), Default 0.00

-- Vérifier les tables créées
SHOW TABLES;
-- Résultat: Achat and Config tables should be listed

-- Vérifier la configuration initiale
SELECT * FROM Config WHERE cleCongif = 'frais_achat_pourcentage';
-- Résultat: Should return one row with valeur = '10'

-- Vérifier les index
SHOW INDEX FROM Achat;
-- Résultat: 4 indexes for idBesoin, idProduit, statut
```

### 2. Configurer les Prix des Produits (Optionnel)

Si vous avez des produits existants, mettre à jour leurs prix:

```sql
UPDATE Produit SET prixUnitaire = 1.50 WHERE idProduit = 1;
UPDATE Produit SET prixUnitaire = 2.00 WHERE idProduit = 2;
-- etc.
```

**Ou manuellement:**
1. Aller à `/produitInsert`
2. Modifier les produits existants (ajouter le prix)

### 3. Accéder à la V2

**Interface Web:**
1. Naviguer vers le dashboard (`/`)
2. Section "Gestion des Achats (V2)" visible
3. Cliquer sur "Nouveau Achat" pour démarrer

**Liens directs:**
- `/achat` - Formulaire d'achat
- `/simulation` - Révision (vide initialement)
- `/recapitulation` - Récap (vide initialement)

### 4. Test Complet du Flux

#### Scénario de Test 1: Création et Validation d'un Achat

**Étape 1: Accès à `/achat`**
- Devrait voir: Formulaire avec sélecteurs besoin/produit, input quantité
- Devrait voir: Section "Achats en Simulation" (vide)
- Devrait voir: Calcul dynamique (montantTotal, frais, total) sous les inputs

**Étape 2: Remplir le formulaire**
```
Besoin: [Sélectionner un besoin existant, ex. "Nourriture"]
Produit: [Sélectionner un produit avec prix, ex. "Riz (1.50€)"]
Quantité: 50
```

**Étape 3: Vérifier le calcul dynamique**
- JavaScript doit calculer:
  ```
  Montant total: 50 × 1.50 = 75.00€
  Frais (10%): 75.00 × 0.10 = 7.50€
  Montant avec frais: 75.00 + 7.50 = 82.50€
  ```

**Étape 4: Soumettre le formulaire**
- Cliquer "Ajouter à la simulation"
- Page doit recharger
- L'achat doit apparaître dans "Achats en Simulation" (inférieur)
- L'achat ne doit pas être en base avec statut 'simulation'

**Étape 5: Accéder à `/simulation`**
- Doit voir: Table avec l'achat créé
  - Colonnes: #, Besoin, Produit, Qté, Prix, Montant, Frais, Total
  - Rangée: [1, Nourriture, Riz, 50, 1.50€, 75.00€, 7.50€, 82.50€]
- Doit voir: Total = 82.50€
- Doit voir: 2 boutons ["Valider tous les achats", "Annuler et revenir à l'achat"]

**Étape 6: Valider les achats**
- Cliquer "Valider tous les achats"
- Alert confirmation doit s'afficher
- Cliquer "OK"
- Redirect vers `/recapitulation`

**Étape 7: Vérifier la récapitulation**
- Doit voir: 4 cards de stats
  ```
  Total des Besoins: [montant total de tous les besoins]
  Montant Satisfait: 82.50€
  Montant Restant: [total - 82.50]
  Taux de Complétion: [satisfaction % ≤ 100%]
  ```
- Doit voir: Barre de progression avec % calculé
- Doit voir: Table "Achats Validés" avec l'achat en statut 'validé'
- Doit voir: Bouton "Effectuer d'autres achats" → route `/achat`

#### Scénario de Test 2: Annulation et Retour

**Étape 1: Créer un autre achat (même flux qu'au-dessus jusqu'à `/simulation`)**

**Étape 2: Annuler la simulation**
- Cliquer "Annuler et revenir à l'achat"
- Alert confirmation doit s'afficher
- Cliquer "OK"
- Redirect vers `/achat`
- Page à `/achat` doit montrer "Achats en Simulation" vide

**Étape 3: Vérifier la base de données**
```sql
SELECT * FROM Achat WHERE statut = 'simulation';
-- Résultat: Aucune ligne (tous les simulations ont été supprimées)
```

#### Scénario de Test 3: Multiples Achats et Validation

**Étape 1-4: Créer 3 achats différents** (répéter pour chaque combinaison besoin/produit)
- Exemple 1: Besoin A, Produit 1, Qty 10
- Exemple 2: Besoin B, Produit 2, Qty 5
- Exemple 3: Besoin A, Produit 3, Qty 20

**Étape 5: Accéder à `/simulation`**
- Table doit avoir 3 lignes

**Étape 6: Valider**
- Total = somme de tous les montantAvecFrais
- Statuts: tous pas 'validé'
- Test le calcul de la gestion-récapitulation stats

### 5. Tests de Sécurité et Edge Cases

#### Test: Quantité = 0 ou négative
```
POST /achat/acheter avec quantite = -5
-> Résultat attendu: Redirect vers /achat sans créer d'achat
```

#### Test: Produit sans prix
```
Créer un produit sans prixUnitaire
POST /achat/acheter avec ce produit
-> Résultat attendu: Redirect sans création (vérification prix > 0)
```

#### Test: Besoin/Produit invalide
```
POST /achat/acheter avec idBesoin=999 (n'existe pas)
-> Résultat attendu: Redirect sans création
```

#### Test: Affichage HTML-Safe
```
Besoin avec caractères spéciaux: "Nourriture & <eau>"
-> Vérifier qu'il s'affiche sans erreur et sans exécution HTML
-> Vérifier source: "Nourriture &amp; &lt;eau&gt;"
```

### 6. Vérification Performance

#### Requêtes Base de Données
```sql
-- Durée d'exécution de /achat GET (charge besoins, produits)
SELECT VERSION(); -- Vérifier MySQL version
-- Test avec EXPLAIN
EXPLAIN SELECT * FROM Besoin WHERE idGroupeId = 1;
EXPLAIN SELECT * FROM Produit WHERE idGroupeId = 1;
EXPLAIN SELECT * FROM Achat WHERE statut = 'simulation';
```

#### Logs
- Vérifier `/app/log/` pour erreurs/warnings
- Vérifier query log si en développement (Tracy Debugger)

### 7. Points de Contrôle Clés

- [ ] Migration SQL exécutée sans erreur
- [ ] Tables Achat et Config créées
- [ ] Colonne prixUnitaire visible dans Produit
- [ ] Frais d'achat = 10% par défaut dans Config
- [ ] Accès à `/achat` fonctionne
- [ ] Formulaire avec selects dynamiques
- [ ] Calcul JavaScript fonctionne (onChange sur quantité/produit)
- [ ] Création d'achat crée une ligne en base (vérifier statut 'simulation')
- [ ] `/simulation` affiche les achats
- [ ] Validation change le statut à 'validé'
- [ ] Annulation supprime les achats
- [ ] `/recapitulation` affiche stats correctes
- [ ] Total montant satisfait = somme des montantAvecFrais achats validés
- [ ] % complétion = (montantTotal / totalBesoins) × 100
- [ ] Liens de navigation fonctionnent

---

## 🎯 Commandes Utiles

### Lancer la Migration
```bash
cd /opt/lampp/htdocs/Projet\ BdD\ Obj/EXAM/2026/Final_S3
mysql -u root -p < sql/18_02_2026_v2_modifications.sql
```

### Voir les Achats en Base
```sql
SELECT * FROM Achat;
SELECT COUNT(*) FROM Achat WHERE statut = 'simulation';
SELECT COUNT(*) FROM Achat WHERE statut = 'validé';
```

### Reset la Base (si besoin)
```sql
DELETE FROM Achat;
DELETE FROM Config;
ALTER TABLE Produit DROP COLUMN prixUnitaire;
DROP TABLE Achat;
DROP TABLE Config;
```

### Test rapide via phpMyAdmin
1. Aller à `http://localhost/phpmyadmin`
2. Sélectionner la base de données
3. Onglet "SQL"
4. Copier/Exécuter le SQL de test

---

## 📋 Validation Finale

Quand tous les tests passent et fonctionnent correctement:

1. Commit les changements en Git (si version control)
2. Documenter les points spécifiques au projet
3. Entraîner les utilisateurs sur le flux
4. Configurer les prix des produits via UI
5. Lancer en production

---

## Support et Debugging

### Si `/achat` affiche une erreur blanche
1. Vérifier les logs `/app/log/`
2. Vérifier que le header.php/footer.php existent
3. Vérifier la connexion BD (test simple SELECT)
4. Vérifier les imports de classe dans routes.php

### Si le formulaire ne submit pas
1. Vérifier l'action du formulaire = `/achat/acheter` correct
2. Vérifier la méthode = POST
3. Vérifier idBesoin, idProduit, quantite ont les bons noms

### Si les calculs JS ne fonctionnent pas
1. Ouvrir DevTools (F12)
2. Aller à Console
3. Vérifier les erreurs JavaScript
4. Vérifier que les éléments HTML ont les bons IDs

---

## Résultat Attendu Final

Une interface intuitive permettant de:
1. ✅ Créer des achats de produits
2. ✅ Voir un aperçu avec calcul automatique des frais
3. ✅ Simuler et valider en masse
4. ✅ Voir une récapitulation avec satisfaction de besoins
5. ✅ Gérer le système de tarification via Config

**État V2: PRÊTE AU DÉPLOIEMENT** ✨

