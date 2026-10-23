# ChangeLog — Select2VanillaBundle

## [0.1.1] — 2026-10-23

### 🐛 Corrections

- **Structure moderne du bundle** : `src/Resources/public`, `src/Resources/views` et `src/Resources/config` sont déplacés respectivement vers `public/`, `templates/` et `config/`. `assets:install` détecte désormais correctement les assets (`AbstractBundle::getPath()` pointe sur la racine du paquet).
- **Thème de formulaire automatique** : `prependExtension()` enregistre `@Select2Vanilla/Form/fields.html.twig` dans `twig.form_themes`. La déclaration manuelle dans `config/packages/twig.yaml` n'est plus nécessaire.
- **Mapping Asset Mapper conditionnel** : il n'est déclaré que si `symfony/asset-mapper` est installé, et pointe désormais vers `public/`.
- **Configuration PHP** : `config/services.php` remplace `services.yaml`, ce qui supprime la dépendance implicite à `symfony/yaml` au chargement du bundle.
- **Initialisation Turbo** : `select2-vanilla-init.js` écoute `DOMContentLoaded` **et** `turbo:load`, et marque chaque champ (`data-select2-initialized`) pour ne jamais l'initialiser deux fois.
- **Pré-sélection** : les valeurs déjà sélectionnées côté serveur sont reprises dans les pills au chargement.
- **Sélection multiple fiabilisée** : grâce à `celtic34fr/select2vanilla` 0.1.2, plus de doublon d'`<option>`, et la suppression d'une pill ne perd plus les autres sélections.
- **Synchronisation des assets** : ajout de `bin/sync-assets.php` et du script Composer `sync-assets` pour régénérer la copie navigateur depuis la librairie.

### 🧪 Tests

- **11 tests unitaires** (contre 8) : ajout de la vérification de la structure `public/` / `templates/` et des chemins d'assets exposés par l'extension DI.

## [0.1.0] — 2026-10-20

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
- **Asset Mapper** : préconfiguration automatique de `framework.asset_mapper.paths` pour exposer les assets de `celtic34fr/select2vanilla` sous le préfixe `select2vanilla` (nécessite `symfony/asset-mapper`).

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
            "url": "https://github.com/celtic34fr/Select2VanillaBundle.git"
        }
    ],
    "require": {
        "celtic34fr/select2vanilla-bundle": "*",
        "celtic34fr/select2vanilla": "dev-master"
    }
}
```

```bash
composer require celtic34fr/select2vanilla-bundle celtic34fr/select2vanilla
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

- `celtic34fr/select2vanilla` (dev-master) : librairie JavaScript vanilla vendored et déclarée via Composer.
- Symfony FrameworkBundle, TwigBundle, Form, OptionsResolver (^8.0).

### 🖥️ Compatibilité

- Compatible avec **Symfony ^8.0** (testé avec Symfony 8.1).
- **Aucune dépendance à Asset Mapper, npm ou Node.js**.
- Les ressources sont exposées via le vendoring classique (`assets:install`).

### 🧪 Tests

- **8 tests unitaires** couvrant le `Select2Type` et la configuration DI (tous passés avec PHPUnit 11.5).
- Les tests couvrent : préfixe de bloc, options par défaut, icône de suppression personnalisable, héritage de `ChoiceType`, support des entités Doctrine, validation et récupération des données soumises, chargement de la configuration globale.

### 🗺️ Feuille de route (TODO)

La version 1.0.0 est visée après implémentation de :
- Accessibilité complète (rôles ARIA, focus clavier)
- Validation HTML5 (`required`)
- Respect de l'état `disabled`
- Support des `<optgroup>`
- Tests d'intégration DOM complets

### 📄 Licence

MIT
