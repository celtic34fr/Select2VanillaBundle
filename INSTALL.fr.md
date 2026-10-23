# Installation et utilisation de Select2VanillaBundle (Français)

Ce bundle permet d'utiliser la librairie JavaScript vanilla [celtic34fr/select2vanilla](https://github.com/celtic34fr/select2vanilla) via un formulaire Symfony (`Select2Type`).

## Prérequis

- PHP ^8.1
- Symfony FrameworkBundle ^8.0
- Symfony TwigBundle ^8.0
- Symfony Form ^8.0

Le bundle est compatible avec **Symfony ^8.0** (testé avec Symfony 8.1). Il n'utilise **pas** Asset Mapper et n'en a pas besoin.

---

## 1. Installation via Composer

Le bundle et sa dépendance JavaScript s'installent avec Composer. Déclarez d'abord le repository Git de la librairie, puis installez le bundle :

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

Puis :

```bash
composer require celtic34fr/select2vanilla-bundle celtic34fr/select2vanilla
```

---

## 2. Enregistrement du bundle

Si Symfony Flex ne l'a pas fait automatiquement, ajoutez le bundle dans `config/bundles.php` :

```php
return [
    // ...
    Select2VanillaBundle\Select2VanillaBundle::class => ['all' => true],
];
```

---

## 3. Thème Twig (automatique)

Le bundle fournit un thème Twig dédié pour le rendu du champ `select2_widget`. Il est enregistré automatiquement par le bundle via `prependExtension()` : aucune configuration dans `config/packages/twig.yaml` n'est nécessaire.

---

## 4. Installation des ressources publiques

Le bundle vendore (embarque) ses propres fichiers JavaScript et CSS. Ils sont indépendants d'Asset Mapper.

Exécutez :

```bash
php bin/console assets:install
```

Les fichiers sont alors copiés dans :

```
public/bundles/select2vanilla/js/select2vanilla.js
public/bundles/select2vanilla/js/select2-vanilla-init.js
public/bundles/select2vanilla/css/select2vanilla.css
```

---

## 5. Inclusion des ressources dans votre layout

Dans votre template de base (par exemple `templates/base.html.twig`), ajoutez les balises suivantes :

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mon application</title>
    <link rel="stylesheet" href="{{ asset('bundles/select2vanilla/css/select2vanilla.css') }}" />
    {# Autres CSS de votre application #}
</head>
<body>
    {# Votre contenu #}

    <script src="{{ asset('bundles/select2vanilla/js/select2vanilla.js') }}"></script>
    <script src="{{ asset('bundles/select2vanilla/js/select2-vanilla-init.js') }}"></script>
    {# Autres JS de votre application #}
</body>
</html>
```

> L'initialisation automatique se fait au chargement du DOM (`DOMContentLoaded`) sur tous les éléments portant la classe `js-select2-vanilla`. Elle est également rejouée après chaque navigation Turbo (`turbo:load`), sans initialiser deux fois le même champ. Vous n'avez rien à coder en JavaScript côté application.

---

## 6. Utilisation dans un formulaire

### Sélection simple (liste de choix)

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

### Sélection multiple

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

## 7. Configuration globale (optionnel)

Vous pouvez définir des valeurs par défaut dans `config/packages/select2_vanilla.yaml` :

```yaml
select2_vanilla:
    remove_icon_html: '<i class="fa fa-times" aria-hidden="true"></i>'
    placeholder: 'Sélectionner...'
    multiple: false
```

Ces valeurs sont surchargeables au niveau de chaque champ via les options du `Select2Type`.

---

## 8. Compatibilité et stratégie d'assets

- Le bundle utilise le **vendoring classique** : les fichiers JS/CSS sont intégrés dans son dossier `public/` et exposés via `assets:install`.
- **Aucune dépendance à Asset Mapper, npm ou Node.js n'est requise**. Asset Mapper reste supporté en option : le mapping est alors déclaré automatiquement.
- Le bundle requiert **Symfony ^8.0** (testé avec Symfony 8.1).

---

## 9. Mise à jour

Pour mettre à jour le bundle et la librairie JavaScript :

```bash
composer update celtic34fr/select2vanilla-bundle celtic34fr/select2vanilla
php bin/console assets:install
```

---

## Licence

MIT
