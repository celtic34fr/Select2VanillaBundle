# Select2VanillaBundle

Bundle Symfony permettant d'utiliser la librairie JavaScript vanilla [celtic34fr/select2vanilla](https://github.com/celtic34fr/select2vanilla) via un formulaire Symfony (`Select2Type`).

## Fonctionnalités

- `Select2Type` étend `ChoiceType` : supporte les choix via tableau et via entité Doctrine (`choice_loader`, `choice_class`, `choice_query_builder`).
- Rendu Twig dédié (`select2_widget`) qui ajoute les attributs `data-*` nécessaires à l'initialisation JavaScript.
- Gestion de la sélection multiple avec affichage des choix sous forme de "pills" et bouton de suppression personnalisable (`remove_icon_html`).
- Assets JS/CSS de `celtic34fr/select2vanilla` exposés automatiquement via **Symfony Asset Mapper**.
- Compatible **Symfony ^8.0** (testé avec Symfony 8.1).
- **8 tests unitaires** couvrant le `Select2Type` et la configuration DI (tous passés).

---

## Installation

### Étape 1 — Installer le bundle et ses dépendances PHP

Dans le **projet hôte** (celui qui installe le bundle) :

```bash
composer require select2-vanilla/bundle celtic34fr/select2vanilla
```

### Étape 2 — Installer Symfony Asset Mapper (recommandé)

Toujours dans le **projet hôte** :

```bash
composer require symfony/asset-mapper
```

> `symfony/asset-mapper` est en `suggest` dans le bundle : il n'est pas installé automatiquement. C'est au projet hôte de l'ajouter s'il souhaite exposer les assets via Asset Mapper.

### Étape 3 — Enregistrer le bundle

Dans `config/bundles.php` (Symfony Flex le fait automatiquement) :

```php
return [
    // ...
    Select2VanillaBundle\Select2VanillaBundle::class => ['all' => true],
];
```

### Étape 4 — Activer le thème Twig

Dans `config/packages/twig.yaml` :

```yaml
twig:
    form_themes:
        - '@Select2Vanilla/Form/fields.html.twig'
```

### Étape 5 — Configurer le mapping des assets (Asset Mapper)

Dans `config/packages/select2_vanilla.yaml` (côté **projet hôte**) :

```yaml
prepend:
    framework:
        asset_mapper:
            paths:
                '%kernel.project_dir%/vendor/celtic34fr/select2vanilla/src': 'select2vanilla'

select2_vanilla:
    remove_icon_html: '<i class="fa fa-times" aria-hidden="true"></i>'
    placeholder: 'Sélectionner...'
    multiple: false
```

> Le bundle tente également de préconfigurer ce mapping automatiquement via son `Extension`, mais déclarer explicitement le bloc `prepend` ci-dessus garantit le bon fonctionnement dans le projet hôte.

### Étape 6 — Importer et compiler les assets

Dans `assets/app.js` (côté **projet hôte**) :

```javascript
import 'select2vanilla/select2vanilla.css';
import 'select2vanilla/select2vanilla.js';
```

Puis compilez les assets :

```bash
php bin/console asset-map:compile
```

Les assets sont alors servis sous le préfixe `bundles/select2vanilla/` par Asset Mapper.

### Étape 7 — Inclure les assets dans votre layout

Dans votre template de base (ex: `base.html.twig`, côté **projet hôte**) :

```twig
<link rel="stylesheet" href="{{ asset('bundles/select2vanilla/select2vanilla.css') }}" />
<script src="{{ asset('bundles/select2vanilla/select2vanilla.js') }}" defer></script>
```

> L'initialisation automatique se fait au `DOMContentLoaded` sur tous les éléments `.js-select2-vanilla`.

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

## Structure

Le code JavaScript/CSS de `celtic34fr/select2vanilla` est installé via Composer dans :

- `vendor/celtic34fr/select2vanilla/src/select2vanilla.js`
- `vendor/celtic34fr/select2vanilla/src/select2vanilla.css`

Ils sont exposés via Asset Mapper sous le préfixe `select2vanilla`.

## Lancer les tests

Le bundle dispose de tests unitaires pour valider le bon fonctionnement du `Select2Type` et de la configuration DI.

### Prérequis

Les dépendances de développement sont requises :

```bash
composer install --dev
```

### Exécution

Depuis la racine du bundle :

```bash
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

---

## Licence

MIT