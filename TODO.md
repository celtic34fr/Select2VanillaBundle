# TODO — Select2VanillaBundle (feuille de route)

Ce fichier recense les tâches à accomplir pour fiabiliser le bundle, améliorer sa couverture de tests et préparer la version 1.0.0.

---
## 0. Configuration de l'application hôte (une fois)

- [x] `APP_SECRET` : défini dans `.env` / variables d'environnement de l'application consommante (côté application, pas dans le bundle lui-même)

---

## 1. Tests (non-régression)

### Tests unitaires existants (déjà implémentés et passés)
- [x] `Select2TypeTest` : préfixe de bloc, options par défaut, icône de suppression, héritage `ChoiceType`, entité Doctrine, données soumises
- [x] `ConfigurationTest` : configuration par défaut et personnalisée (`remove_icon_html`, `placeholder`, `multiple`)
- [x] `Select2VanillaBundleTest` : structure moderne (`public/`, `templates/`), script navigateur sans `export default`, chemins d'assets de l'extension DI

**Statut :** 11 tests unitaires, tous passés avec PHPUnit 11.5 sous Symfony 8.1.

### Tests à ajouter (priorité haute)

#### 1.1 Thème Twig (`fields.html.twig`)
- [ ] Vérifier que le bloc `select2_widget` génère la classe `js-select2-vanilla`
- [ ] Vérifier que les attributs `data-*` sont rendus (`data-select2-vanilla`, `data-multiple`, `data-placeholder`, `data-remove-icon-html`)
- [ ] Vérifier que `remove_icon_html` est transmis correctement dans les `data-*`

#### 1.2 Extension DI (`Select2VanillaExtension`)
- [ ] Tester que les paramètres sont bien définis dans le conteneur (`select2_vanilla.remove_icon_html`, etc.)
- [x] Tester le chargement du fichier `config/services.php`

#### 1.3 Tests fonctionnels (intégration Symfony)
- [ ] Créer un formulaire de test avec `Select2Type` et vérifier le rendu HTML
- [ ] Tester la soumission d'un formulaire avec sélection simple et multiple
- [ ] Tester l'initialisation JavaScript via `select2-vanilla-init.js` (si possible avec un navigateur headless)

### Infrastructure de tests
- [ ] Configurer GitHub Actions (ou équivalent) pour lancer `phpunit` à chaque push/PR
- [ ] Ajouter un badge de statut de build dans le `README.md`

---

## 2. Fiabilisation du bundle (stabilisation)

### 2.1 Séparation des assets (vendoring vs Asset Mapper)
- [x] Documenter clairement que le bundle utilise le vendoring classique (`public/`)
- [x] Déclarer automatiquement le mapping Asset Mapper vers `public/` si le composant est installé
- [x] Ajouter un script `sync-assets` (`bin/sync-assets.php`) pour synchroniser les assets vendored depuis `vendor/`

### 2.2 Accessibilité (a11y)
- [ ] Ajouter des rôles ARIA sur le conteneur custom généré par le thème Twig
- [ ] S'assurer que l'input de recherche est correctement associé à son label
- [ ] Gérer le focus clavier dans le dropdown (flèches, Entrée, Échap)

### 2.3 Validation HTML5
- [ ] Propager l'attribut `required` du champ Symfony vers le rendu HTML du custom select
- [ ] Tester la validation de formulaire avec un champ requis vide

### 2.4 État `disabled`
- [ ] Propager l'attribut `disabled` du champ Symfony vers le composant custom
- [ ] Empêcher l'interaction (clic, saisie) quand le champ est désactivé

### 2.5 Groupes d'options (`<optgroup>`)
- [ ] Vérifier que le thème Twig gère les `<optgroup>` natifs de `ChoiceType`
- [ ] Tester le rendu visuel des groupes dans le dropdown

### 2.6 Mise à jour dynamique des choix
- [ ] Documenter comment ajouter/supprimer des choix après initialisation (via JavaScript)
- [ ] Prévoir une option Symfony pour recharger les choix dynamiquement (si pertinent)

### 2.7 CSS et rendu visuel
- [ ] Vérifier la compatibilité avec Bootstrap 5, Tailwind CSS, et CSS pur
- [ ] Ajouter des styles pour l'état de focus (anneau visible)
- [ ] Vérifier le comportement responsive du dropdown (pas de dépassement de la fenêtre)

---

## 3. Documentation

### 3.1 Documentation existante (déjà implémentée)
- [x] `README.md` : installation, utilisation, thèmes Twig, exemples
- [x] `INSTALL.fr.md` / `INSTALL.en.md` : guide d'installation détaillé
- [x] `ChangeLog.md` : historique de la version 0.1.0

### 3.2 Documentation à compléter
- [ ] Exemples d'intégration avec Bootstrap 5 et Tailwind CSS
- [ ] Documentation des événements JavaScript personnalisés (`change`, `filter`)
- [ ] Guide de migration vers la version 1.0.0 (quand elle sera disponible)
- [ ] FAQ : problèmes connus et contournements

---

## 4. Versions

### Version 0.1.1 (actuelle)
- Structure moderne `public/` / `templates/` / `config/`, compatible `assets:install`
- Thème Twig enregistré automatiquement, initialisation Turbo idempotente
- Pré-sélection des valeurs serveur et sélection multiple fiabilisée
- 11 tests unitaires passés (PHPUnit 11.5, Symfony 8.1)
- Compatible Symfony ^8.0
- Dépendance `celtic34fr/select2vanilla` en `dev-master`

### Version 0.2.0 (prochaine étape)
- Ajout des tests Twig et fonctionnels
- CI/CD configurée
- Corrections d'accessibilité de base (rôles ARIA, focus clavier)

### Version 1.0.0 (objectif)
- Bundle stable et prêt pour la production
- Couverture de tests complète (unitaires + fonctionnels)
- Accessibilité complète (WCAG 2.1 AA)
- Documentation exhaustive

---

## 5. Comment contribuer

1. Choisir une tâche dans la liste ci-dessus
2. Créer une branche dédiée depuis `main`
3. Implémenter la fonctionnalité avec ses tests
4. Mettre à jour ce fichier `TODO.md` en cochant la tâche
5. Mettre à jour le `ChangeLog.md`
6. Ouvrir une Pull Request vers `main`
