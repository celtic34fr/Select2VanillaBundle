# Select2VanillaBundle

Bundle Symfony permettant d'utiliser la librairie JavaScript vanilla [celtic34fr/select2vanilla](https://github.com/celtic34fr/select2vanilla) via un formulaire Symfony (`Select2Type`).

## Fonctionnalités

- `Select2Type` étend `ChoiceType` : supporte les choix via tableau et via entité Doctrine (`choice_loader`, `choice_class`, `choice_query_builder`).
- Rendu Twig dédié (`select2_widget`) qui ajoute les attributs `data-*` nécessaires à l'initialisation JavaScript.
- Gestion de la sélection multiple avec affichage des choix sous forme de "pills" et bouton de suppression personnalisable (`remove_icon_html`).
- Assets JS/CSS vendored et exposés via `assets:install`.

## Installation

```bash
composer require select2-vanilla/bundle
```

### 1. Enregistrer le bundle

Dans `config/bundles.php` (Symfony Flex le fait automatiquement) :

```php
return [
    // ...
    Select2VanillaBundle\Select2VanillaBundle::class => ['all' => true],
];
```

### 2. Activer le thème Twig

Dans `config/packages/twig.yaml` :

```yaml
twig:
    form_themes:
        - '@Select2Vanilla/Form/fields.html.twig'
```

### 3. Publier les assets

```bash
php bin/console assets:install
```

Les fichiers JS/CSS sont alors disponibles sous `public/bundles/select2vanilla/`.

### 4. Inclure les assets dans votre layout

Dans votre template de base (ex: `base.html.twig`) :

```twig
{% javascripts '@Select2VanillaBundle/Resources/public/js/*' %}
    <script src="{{ asset_url }}"></script>
{% endjavascripts %}

{% stylesheets '@Select2VanillaBundle/Resources/public/css/*' %}
    <link rel="stylesheet" href="{{ asset_url }}" />
{% endstylesheets %}
```

Ou manuellement :

```html
<script src="{{ asset('bundles/select2vanilla/js/select2vanilla.js') }}"></script>
<script src="{{ asset('bundles/select2vanilla/js/select2-vanilla-init.js') }}"></script>
<link rel="stylesheet" href="{{ asset('bundles/select2vanilla/css/select2vanilla.css') }}" />
```

> L'initialisation automatique se fait au `DOMContentLoaded` sur tous les éléments `.js-select2-vanilla`.

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

### Configuration globale (optionnel)

Dans `config/packages/select2_vanilla.yaml` :

```yaml
select2_vanilla:
    remove_icon_html: '<i class="fa fa-times" aria-hidden="true"></i>'
    placeholder: 'Sélectionner...'
    multiple: false
```

## Structure du dépôt tiers

Le code JavaScript/CSS de `celtic34fr/select2vanilla` est vendored dans :
- `src/Resources/public/js/select2vanilla.js`
- `src/Resources/public/css/select2vanilla.css`

Le fichier `select2-vanilla-init.js` assure l'amorçage depuis les `data-*` du thème Twig.

## Licence

MIT
