# Select2VanillaBundle

Bundle Symfony permettant d'utiliser la librairie JavaScript vanilla [celtic34fr/select2vanilla](https://github.com/celtic34fr/select2vanilla) via un formulaire Symfony (`Select2Type`).

## Fonctionnalités

- `Select2Type` étend `ChoiceType` : supporte les choix via tableau et via entité Doctrine (`choice_loader`, `choice_class`, `choice_query_builder`).
- Rendu Twig dédié (`select2_widget`) qui ajoute les attributs `data-*` nécessaires à l'initialisation JavaScript.
- Sélection multiple avec affichage des choix sous forme de « pills » et bouton de suppression personnalisable (`remove_icon_html`).
- Assets JS/CSS de `celtic34fr/select2vanilla` embarqués dans le bundle et publiés via `assets:install`.
- Mapping **Asset Mapper** automatique si `symfony/asset-mapper` est installé (optionnel).
- **Thème de formulaire enregistré automatiquement** : plus besoin de le déclarer dans `config/packages/twig.yaml`.
- Initialisation JavaScript compatible **Turbo** (`DOMContentLoaded` + `turbo:load`), idempotente.
- Compatible **Symfony ^8.0** (testé avec Symfony 8.1).
- **11 tests unitaires** (PHPUnit).

---

## Installation

### Étape 1 — Installer le bundle et sa dépendance JavaScript

Dans le **projet hôte** :

```bash
composer require celtic34fr/select2vanilla-bundle celtic34fr/select2vanilla
```

### Étape 2 — Enregistrer le bundle

Dans `config/bundles.php` (Symfony Flex le fait automatiquement) :

```php
return [
    // ...
    Select2VanillaBundle\Select2VanillaBundle::class => ['all' => true],
];
```

### Étape 3 — Publier les assets

```bash
php bin/console assets:install
```

Les fichiers sont copiés dans :

```
public/bundles/select2vanilla/css/select2vanilla.css
public/bundles/select2vanilla/js/select2vanilla.js
public/bundles/select2vanilla/js/select2-vanilla-init.js
```

> `assets:install` est généralement déjà exécuté automatiquement par les auto-scripts Composer de Symfony Flex.

### Étape 4 — Inclure les assets dans le layout

Dans votre template de base (ex. `base.html.twig`) :

```twig
<link rel="stylesheet" href="{{ asset('bundles/select2vanilla/css/select2vanilla.css') }}" />

{# ... en bas de page ... #}
<script src="{{ asset('bundles/select2vanilla/js/select2vanilla.js') }}" defer></script>
<script src="{{ asset('bundles/select2vanilla/js/select2-vanilla-init.js') }}" defer></script>
```

L'initialisation est automatique sur tous les éléments portant la classe `js-select2-vanilla`. Elle est rejouée après chaque navigation Turbo sans réinitialiser deux fois le même champ.

### Étape 5 — Utiliser `Select2Type`

Le thème de formulaire est enregistré par le bundle : aucune configuration Twig supplémentaire n'est nécessaire.

---

## Utilisation

### Liste simple (tableau)

```php
use Select2VanillaBundle\Form\Type\Select2Type;

$builder->add('status', Select2Type::class, [
    'choices' => [
        'Actif' => 'active',
        'Inactif' => 'inactive',
    ],
    'placeholder' => 'Choisir un statut',
]);
```

### Sélection multiple (tableau)

```php
$builder->add('tags', Select2Type::class, [
    'choices' => [
        'PHP' => 'php',
        'Symfony' => 'symfony',
        'JavaScript' => 'javascript',
    ],
    'multiple' => true,
    'placeholder' => 'Choisir des tags',
    'remove_icon_html' => '<i class="fa fa-times" aria-hidden="true"></i>',
]);
```

### Entité Doctrine

```php
use App\Entity\Category;

$builder->add('category', Select2Type::class, [
    'class' => Category::class,
    'choice_label' => 'name',
    'placeholder' => 'Choisir une catégorie',
]);
```

---

## Configuration globale (optionnel)

Dans `config/packages/select2_vanilla.yaml` :

```yaml
select2_vanilla:
    remove_icon_html: '<i class="fa fa-times" aria-hidden="true"></i>'
    placeholder: 'Sélectionner...'
    multiple: false
```

Ces valeurs sont surchargeables au niveau de chaque champ.

---

## Asset Mapper (optionnel)

Si le projet hôte utilise `symfony/asset-mapper`, le bundle déclare automatiquement le mapping de son dossier `public/` sous le préfixe `select2vanilla`. Les chemins logiques sont alors :

```
select2vanilla/css/select2vanilla.css
select2vanilla/js/select2vanilla.js
select2vanilla/js/select2-vanilla-init.js
```

`assets:install` reste la méthode recommandée pour un projet Symfony classique (sans Asset Mapper).

---

## Structure du bundle

```
bin/sync-assets.php          # resynchronise le JS/CSS depuis la librairie
config/services.php          # services du bundle (config PHP, sans dépendance YAML)
public/css/                  # CSS publié par assets:install
public/js/                   # JS de la librairie + script d'initialisation
src/                         # bundle, extension DI, Select2Type
templates/Form/fields.html.twig
tests/                       # tests PHPUnit
```

### Mainteneurs — synchroniser les assets

Après une mise à jour de `celtic34fr/select2vanilla` :

```bash
composer update celtic34fr/select2vanilla
composer sync-assets
```

Le script `bin/sync-assets.php` copie `select2vanilla.js` / `select2vanilla.css` et retire la ligne `export default` pour produire un script navigateur classique. Il accepte aussi un chemin source explicite :

```bash
php bin/sync-assets.php /chemin/vers/select2vanilla/src
```

---

## Lancer les tests

```bash
composer install
vendor/bin/phpunit
```

Les tests couvrent :

- Le préfixe de bloc `select2` du `Select2Type`
- Les options par défaut (`remove_icon_html`, `choices`, etc.)
- La personnalisation de l'icône de suppression
- L'héritage de `ChoiceType` (placeholder, multiple)
- Le support des entités Doctrine
- La validation et la récupération des données soumises
- Le chargement de la configuration globale (`select2_vanilla.yaml`)
- La structure moderne du bundle (`public/`, `templates/`) et les chemins d'assets de l'extension DI

---

## Licence

MIT
