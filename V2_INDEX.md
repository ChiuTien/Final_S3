# Index V2 - Guide de Navigation

**Bienvenue dans l'implémentation V2!**  
Ce fichier vous aide à naviguer rapidement dans l'architecture V2.

---

## 📚 Documentation Recommandée

### Pour les Managers & Clients
1. **[SESSION_V2_REPORT.md](./SESSION_V2_REPORT.md)** - Résumé exécutif
   - Réalisations
   - Statistiques
   - Prochaines étapes

2. **[RESUME_V2.md](./RESUME_V2.md)** - Résumé détaillé
   - Fichiers créés/modifiés
   - Flux de données
   - Compatibilité
   - Déploiement

### Pour les Développeurs
1. **[V2_DOCUMENTATION.md](./V2_DOCUMENTATION.md)** - Documentation technique
   - Architecture complète
   - Modèles
   - Repositories
   - Calculs
   - Configuration

2. **[CHECKLIST_V2.md](./CHECKLIST_V2.md)** - Guide test & déploiement
   - Migration SQL
   - Scénarios test (3 complets)
   - Edge cases
   - Debugging

### Pour les QA & Testeurs
- [CHECKLIST_V2.md](./CHECKLIST_V2.md) - Test cases
- Section "Test Complet du Flux" pour validation E2E

### Pour les DevOps & DBA
- [CHECKLIST_V2.md](./CHECKLIST_V2.md) - Section "Exécuter la Migration"
- [sql/18_02_2026_v2_modifications.sql](./sql/18_02_2026_v2_modifications.sql) - Script migration

---

## 🗂️ Arborescence V2

```
Projet BdD Obj/EXAM/2026/Final_S3/
│
├─ 📄 V2_DOCUMENTATION.md ..................... Guide complet technique
├─ 📄 CHECKLIST_V2.md ........................ Test cases & déploiement
├─ 📄 RESUME_V2.md ........................... Résumé des changements
├─ 📄 SESSION_V2_REPORT.md ................... Rapport de session
├─ 📄 V2_INDEX.md ............................ Ce fichier
│
├─ 📁 app/models/
│  ├─ Achat.php ............................. Modèle transaction achat
│  ├─ Config.php ............................ Modèle configuration
│  └─ Produit.php ........................... (modifié: add prixUnitaire)
│
├─ 📁 app/repository/
│  ├─ RepAchat.php .......................... Repository achats
│  ├─ RepConfig.php ......................... Repository config
│  └─ RepProduit.php ........................ (modifié: hydrate prix)
│
├─ 📁 app/controllers/
│  ├─ ControllerAchat.php .................. Contrôleur achats
│  └─ ControllerConfig.php ................. Contrôleur config
│
├─ 📁 app/views/
│  ├─ achat.php ............................. Formulaire achat (NEW)
│  ├─ simulation.php ........................ Révision validation (NEW)
│  ├─ recapitulation.php ................... Récapitulatif stats (NEW)
│  └─ welcome.php ........................... (modifié: add V2 section)
│
├─ 📁 app/config/
│  └─ routes.php ............................ (modifié: add 6 routes V2)
│
└─ 📁 sql/
   └─ 18_02_2026_v2_modifications.sql ...... Migration BD V2

```

---

## 🔍 Trouver Rapidement

### Par Fonctionnalité

#### ✅ Créer un Achat
**Fichiers impliqués:**
- Modèle: [`app/models/Achat.php`](./app/models/Achat.php)
- Repository: [`app/repository/RepAchat.php`](./app/repository/RepAchat.php) → `addAchat()`
- Contrôleur: [`app/controllers/ControllerAchat.php`](./app/controllers/ControllerAchat.php) → `addAchat()`
- Route: [`app/config/routes.php`](./app/config/routes.php) → `POST /achat/acheter` (ligne ~533)
- Vue: [`app/views/achat.php`](./app/views/achat.php)

**Flux:** 
```
POST /achat/acheter 
  → ControllerAchat.addAchat() 
  → RepAchat.addAchat() 
  → INSERT Achat table 
  → redirect /achat
```

#### ✅ Simuler des Achats
**Fichiers impliqués:**
- Route: [`app/config/routes.php`](./app/config/routes.php) → `GET /simulation` (ligne ~581)
- Vue: [`app/views/simulation.php`](./app/views/simulation.php)
- Contrôleur: [`app/controllers/ControllerAchat.php`](./app/controllers/ControllerAchat.php) → `getAchatsSimulation()`

**Flux:**
```
GET /simulation 
  → ControllerAchat.getAchatsSimulation() 
  → RepAchat.getAllAchats('simulation') 
  → SELECT FROM Achat WHERE statut='simulation' 
  → render simulation.php
```

#### ✅ Valider des Achats
**Fichiers impliqués:**
- Route: [`app/config/routes.php`](./app/config/routes.php) → `POST /simulation/valider` (ligne ~605)
- Contrôleur: [`app/controllers/ControllerAchat.php`](./app/controllers/ControllerAchat.php) → `updateStatutAchat()`
- Repository: [`app/repository/RepAchat.php`](./app/repository/RepAchat.php) → `updateStatutAchat()`

**Flux:**
```
POST /simulation/valider 
  → Loop achatsSimulation 
    → ControllerAchat.updateStatutAchat() 
      → RepAchat.updateStatutAchat() 
        → UPDATE Achat SET statut='validé' 
  → redirect /recapitulation
```

#### ✅ Calculer les Frais
**Fichiers impliqués:**
- Contrôleur Config: [`app/controllers/ControllerConfig.php`](./app/controllers/ControllerConfig.php) → `getFraisAchatPourcentage()`
- Route: [`app/config/routes.php`](./app/config/routes.php) → `POST /achat/acheter` (ligne ~555)
- Vue: [`app/views/achat.php`](./app/views/achat.php) → JavaScript calculerMontant()

**Formule:**
```
montantTotal = quantite × prixUnitaire
fraisAchat = montantTotal × (fraisPercent / 100)
montantAvecFrais = montantTotal + fraisAchat
```

#### ✅ Voir Récapitulation
**Fichiers impliqués:**
- Route: [`app/config/routes.php`](./app/config/routes.php) → `GET /recapitulation` (ligne ~637)
- Vue: [`app/views/recapitulation.php`](./app/views/recapitulation.php)
- Contrôleur: [`app/controllers/ControllerAchat.php`](./app/controllers/ControllerAchat.php) → `getAchatsValides()`

**Stats calculées:**
```
totalBesoins = SUM(val_besoin) for all besoins
montantTotal = SUM(montantAvecFrais) for achats validés
montantRestant = totalBesoins - montantTotal
pourcentageCompletion = (montantTotal / totalBesoins) × 100
```

### Par Type de Fichier

#### Models (3 fichiers)
- [`app/models/Achat.php`](./app/models/Achat.php) - 10 attributes
- [`app/models/Config.php`](./app/models/Config.php) - 4 attributes
- [`app/models/Produit.php`](./app/models/Produit.php) - add prixUnitaire

#### Repositories (3 fichiers)
- [`app/repository/RepAchat.php`](./app/repository/RepAchat.php) - 5 méthodes CRUD
- [`app/repository/RepConfig.php`](./app/repository/RepConfig.php) - 4 méthodes
- [`app/repository/RepProduit.php`](./app/repository/RepProduit.php) - 2 modifiées

#### Controllers (2 fichiers)
- [`app/controllers/ControllerAchat.php`](./app/controllers/ControllerAchat.php) - 7 méthodes
- [`app/controllers/ControllerConfig.php`](./app/controllers/ControllerConfig.php) - 5 méthodes

#### Views (4 fichiers)
- [`app/views/achat.php`](./app/views/achat.php) - Formulaire (NEW)
- [`app/views/simulation.php`](./app/views/simulation.php) - Révision (NEW)
- [`app/views/recapitulation.php`](./app/views/recapitulation.php) - Récap (NEW)
- [`app/views/welcome.php`](./app/views/welcome.php) - Menu (modifié)

#### Routes (1 fichier)
- [`app/config/routes.php`](./app/config/routes.php) - 6 routes V2

#### SQL (1 fichier)
- [`sql/18_02_2026_v2_modifications.sql`](./sql/18_02_2026_v2_modifications.sql) - Migration BD

---

## 🎓 Tutoriels Rapides

### Tutoriel 1: Ajouter un nouveau paramètre de configuration

**Objectif:** Ajouter un nouveau param système (ex: `taxe_supplementaire`)

**Étapes:**

1. Insérer en BD:
```sql
INSERT INTO Config (cleCongif, valeur, description) 
VALUES ('taxe_supplementaire', '5', 'Taxe supplémentaire %');
```

2.1 Dans le code (méthode A - pas de code change):
```php
$taxe = $controllerConfig->getConfigValue('taxe_supplementaire', 0);
```

2.2 Dans le code (méthode B - créer helper):
```php
// app/controllers/ControllerConfig.php
public function getTaxeSupplémentaire(): float {
    return floatval($this->getConfigValue('taxe_supplementaire', 0));
}
```

3. Utiliser dans la route:
```php
$taxe = $controllerConfig->getTaxeSupplémentaire();
```

**Fichiers modifiés minimum:** 2 (BD + 1 contrôleur ou route)

---

### Tutoriel 2: Modifier le prix d'un produit

**Objectif:** Changer le prixUnitaire d'un produit

**Via SQL:**
```sql
UPDATE Produit SET prixUnitaire = 2.50 WHERE idProduit = 5;
```

**Via UI (futur):**
```
Route POST /produit/update avec prix dans body
```

**Impact:**
- Les achats futurs utiliseront le nouveau prix
- Les achats existants conservent le prix snapshot (immutable)

---

### Tutoriel 3: Tester une achat de A à Z

**Étapes:**

1. Accéder à `/achat`
2. Sélectionner:
   - Besoin (ex: "Nourriture")
   - Produit avec prixUnitaire > 0
   - Quantité > 0
3. Vérifier calcul JS (montants affichés)
4. Cliquer "Ajouter à la simulation"
5. Vérifier achat dans liste (bas de page)
6. Cliquer "Voir la Simulation"
7. Vérifier table avec achat + total
8. Cliquer "Valider tous les achats"
9. Confirmer dialog
10. Vérifier `/recapitulation`:
    - Stats update
    - Achat en table "Achats Validés"
    - Montant satisfait = montantAvecFrais
    - % augmenté

**Base de données check:**
```sql
SELECT * FROM Achat WHERE statut = 'validé' ORDER BY dateAchat DESC LIMIT 1;
-- Vérifier: idBesoin, idProduit, montantFrais, montantAvecFrais
```

---

## 🔗 URLs Rapides

| Action | URL | Méthode |
|--------|-----|---------|
| Formulaire achat | `/achat` | GET |
| Créer achat | `/achat/acheter` | POST |
| Simuler | `/simulation` | GET |
| Valider | `/simulation/valider` | POST |
| Rejeter | `/simulation/rejeter` | POST |
| Récap | `/recapitulation` | GET |
| Dashboard | `/` | GET |

---

## 💾 Commandes BD Utiles

```bash
# Voir tous les achats
SELECT * FROM Achat;

# Voir achats en simulation
SELECT * FROM Achat WHERE statut='simulation';

# Voir achats validés
SELECT * FROM Achat WHERE statut='validé';

# Voir totaux par statut
SELECT statut, COUNT(*as cnt, SUM(montantAvecFrais) as total FROM Achat GROUP BY statut;

# Voir config
SELECT * FROM Config;

# Voir produits avec prix
SELECT idProduit, val, prixUnitaire FROM Produit WHERE prixUnitaire > 0;

# Supprimer tous les achats de test
DELETE FROM Achat WHERE dateAchat > NOW() - INTERVAL 1 DAY;
```

---

## 📞 Support

### Erreurs Courantes

#### Erreur: "Call to undefined method..."
- Vérifier que `use` statement est dans le fichier
- Vérifier `composer dump-autoload`
- Vérifier namespace cohérent

#### Erreur: "Column 'prixUnitaire' doesn't exist in..."
- Migration SQL pas exécutée
- Exécuter: `sql/18_02_2026_v2_modifications.sql`

#### Erreur: "ENUM value out of range"
- Vérifier statut en ('simulation', 'validé', 'rejeté')
- Pas de typo sur 'validé' (avec accent)

#### Calcul JS ne fonctionne pas
- F12 → Console → vérifier erreurs
- Vérifier IDs HTML: `idBesoin`, `idProduit`, `quantite`
- Vérifier `data-prix` sur option select

---

## 📈 Prochaines Lectures

Après avoir lu ce guide:

1. **Lire:** [V2_DOCUMENTATION.md](./V2_DOCUMENTATION.md) pour architecture complète
2. **Tester:** [CHECKLIST_V2.md](./CHECKLIST_V2.md) pour validation E2E
3. **Déployer:** Exécuter migration SQL
4. **Améliorer:** Consulter "Points d'amélioration" dans RESUME_V2.md

---

## 📊 Checklist d'Intégration

- [ ] Lire ce fichier (V2_INDEX.md)
- [ ] Lire V2_DOCUMENTATION.md
- [ ] Exécuter migration SQL
- [ ] Tester scénario 1 (création)
- [ ] Tester scénario 2 (rejeter)
- [ ] Tester scénario 3 (multiples)
- [ ] Valider sécurité (edge cases)
- [ ] Vérifier logs erreurs
- [ ] Configurer prix produits
- [ ] Former utilisateurs
- [ ] Déployer production

---

## 🎉 Vous Êtes Prêt!

La V2 est complète et documentée. Naviguez avec ce guide pour comprendre rapidement l'architecture.

**Questions?** Consulter:
- Code source (bien commenté)
- V2_DOCUMENTATION.md (détails)
- CHECKLIST_V2.md (test & debug)

**Bonne lecture! 📚**

---

**Version:** 1.0  
**Date:** 18/02/2026  
**Status:** ✅ Complète  

