# ChangeLog — Select2VanillaBundle

## [0.1.0] — 2026-10-19

Première version du bundle Symfony `Select2VanillaBundle`.

### ✨ Fonctionnalités principales

- **`Select2Type`** : nouveau FormType qui étend nativement `Symfony\Component\Form\Extension\Core\Type\ChoiceType`. Il hérite donc du support des choix sous forme de tableau (`choices`) et de lecture dans une entité Doctrine (`choice_loader`, `choice_class`, `choice_query_builder`, etc.) sans aucune logique supplémentaire.
- **Option `remove_icon_html`** : permet de personnaliser le HTML du bouton de suppression de chaque sélection multiple (par défaut `×`, ex. `<i class="fa fa-times" aria-hidden="true"></i>`).
- **Thème Twig `select2_widget`** : bloc dédié générant un `<select>` avec la classe `js-select2-vanilla` et les attributs `data-*` nécessaires (`data-select2-vanilla`, `data-multiple`, `data-placeholder`, `data-remove-icon-html`).
- **JavaScript vendored** :
  - `select2vanilla.js` : librairie vanilla corrigée et fiabilisée (export de la classe, `destroy()`, `removeIconHtml`, gestion du multiple, suppression des pills, etc.).
  - `select2-vanilla-init.js` : script d'initialisation automatique au `DOMContentLoaded` sur tous les éléments `.js-select2-vanilla`.
- **CSS vendored** : styles du composant custom select, des pills de sélection, et de la croix de suppression positionnée en haut-droite.
- **Configuration Symfony** : `select2_vanilla.remove_icon_html`, `select2_vanilla.placeholder`, `select2_vanilla.multiple` via `config/packages/select2_vanilla.yaml`.

### 📦 Installation

1. Déclarer le repository VCS et installer le bundle :

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/celtic34fr/select2vanilla.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/select2-vanilla/bundle.git"
        }
    ],
    "require": {
        "select2-vanilla/bundle": "*",
        "celtic34fr/select2vanilla": "^0.1"
    }
}
```

```bash
composer require select2-vanilla/bundle celtic34fr/select2vanilla
```

2. Enregistrer le bundle dans `config/bundles.php` (automatique avec Symfony Flex).

3. Activer le thème Twig dans `config/packages/twig.yaml` :

```yaml
twig:
    form_themes:
        - '@Select2Vanilla/Form/fields.html.twig'
```

4. Publier les assets :

```bash
php bin/console assets:install
```

5. Inclure les ressources dans le layout (ex: `base.html.twig`) :

```html
<link rel="stylesheet" href="{{ asset('bundles/select2vanilla/css/select2vanilla.css') }}" />
<script src="{{ asset('bundles/select2vanilla/js/select2vanilla.js') }}"></script>
<script src="{{ asset('bundles/select2vanilla/js/select2-vanilla-init.js') }}"></script>
```

### 📋 Utilisation

```php
use Select2VanillaBundle\Form\Type\Select2Type;

// Liste simple
$builder->add('status', Select2Type::class, [
    'choices' => ['Actif' => 'active', 'Inactif' => 'inactive'],
    'placeholder' => 'Choisir un statut',
]);

// Sélection multiple
$builder->add('tags', Select2Type::class, [
    'choices' => ['PHP' => 'php', 'Symfony' => 'symfony'],
    'multiple' => true,
    'placeholder' => 'Choisir des tags',
    'remove_icon_html' => '<i class="fa fa-times" aria-hidden="true"></i>',
]);

// Entité Doctrine
$builder->add('category', Select2Type::class, [
    'class' => Category::class,
    'choice_label' => 'name',
    'placeholder' => 'Choisir une catégorie',
]);
```

### 🔧 Dépendances

- `celtic34fr/select2vanilla` (^0.1) : librairie JavaScript vanilla vendored et déclarée via Composer.
- Symfony FrameworkBundle, TwigBundle, Form, OptionsResolver (^6.4 | ^7.0).

### 🖥️ Compatibilité

- Compatible avec **toutes les versions de Symfony**, y compris antérieures à la 6.2.
- **Aucune dépendance à Asset Mapper, npm ou Node.js**.
- Les ressources sont exposées via le vendoring classique (`assets:install`).

### 🗺️ Feuille de route (TODO)

La version 1.0.0 est visée après implémentation de :
- Accessibilité complète (rôles ARIA, focus clavier)
- Validation HTML5 (`required`)
- Respect de l'état `disabled`
- Support des `<optgroup>`
- Tests d'intégration DOM complets

### 📄 Licence

MIT
