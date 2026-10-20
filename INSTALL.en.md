# Installation and usage of Select2VanillaBundle (English)

This bundle allows you to use the vanilla JavaScript library [celtic34fr/select2vanilla](https://github.com/celtic34fr/select2vanilla) via a Symfony form (`Select2Type`).

## Requirements

- PHP ^8.1
- Symfony FrameworkBundle ^8.0
- Symfony TwigBundle ^8.0
- Symfony Form ^8.0

The bundle is compatible with **Symfony ^8.0** (tested with Symfony 8.1). It does **not** use Asset Mapper and does not require it.

---

## 1. Installation via Composer

The bundle and its JavaScript dependency are installed via Composer. First declare the Git repository of the library, then install the bundle:

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

Then:

```bash
composer require select2-vanilla/bundle celtic34fr/select2vanilla
```

---

## 2. Register the bundle

If Symfony Flex did not do it automatically, add the bundle in `config/bundles.php`:

```php
return [
    // ...
    Select2VanillaBundle\Select2VanillaBundle::class => ['all' => true],
];
```

---

## 3. Enable the Twig theme

The bundle provides a dedicated Twig theme for rendering the `select2_widget` field. Enable it in `config/packages/twig.yaml`:

```yaml
twig:
    form_themes:
        - '@Select2Vanilla/Form/fields.html.twig'
```

---

## 4. Install public assets

The bundle vendors (embeds) its own JavaScript and CSS files. They are independent of Asset Mapper.

Run:

```bash
php bin/console assets:install
```

The files are then copied to:

```
public/bundles/select2vanilla/js/select2vanilla.js
public/bundles/select2vanilla/js/select2-vanilla-init.js
public/bundles/select2vanilla/css/select2vanilla.css
```

---

## 5. Include resources in your layout

In your base template (for example `templates/base.html.twig`), add the following tags:

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My application</title>
    <link rel="stylesheet" href="{{ asset('bundles/select2vanilla/css/select2vanilla.css') }}" />
    {# Other CSS of your application #}
</head>
<body>
    {# Your content #}

    <script src="{{ asset('bundles/select2vanilla/js/select2vanilla.js') }}"></script>
    <script src="{{ asset('bundles/select2vanilla/js/select2-vanilla-init.js') }}"></script>
    {# Other JS of your application #}
</body>
</html>
```

> Initialization happens automatically on DOM load (`DOMContentLoaded`) for all elements with the class `js-select2-vanilla`. You have nothing to code in JavaScript on the application side.

---

## 6. Usage in a form

### Simple selection (choice list)

```php
use Select2VanillaBundle\Form\Type\Select2Type;

$builder->add('status', Select2Type::class, [
    'choices' => [
        'Active' => 'active',
        'Inactive' => 'inactive',
    ],
    'placeholder' => 'Choose a status',
]);
```

### Multiple selection

```php
$builder->add('tags', Select2Type::class, [
    'choices' => [
        'PHP' => 'php',
        'Symfony' => 'symfony',
        'JavaScript' => 'javascript',
    ],
    'multiple' => true,
    'placeholder' => 'Choose tags',
    'remove_icon_html' => '<i class="fa fa-times" aria-hidden="true"></i>',
]);
```

### Doctrine entity

```php
use App\Entity\Category;

$builder->add('category', Select2Type::class, [
    'class' => Category::class,
    'choice_label' => 'name',
    'placeholder' => 'Choose a category',
]);
```

---

## 7. Global configuration (optional)

You can set default values in `config/packages/select2_vanilla.yaml`:

```yaml
select2_vanilla:
    remove_icon_html: '<i class="fa fa-times" aria-hidden="true"></i>'
    placeholder: 'Select...'
    multiple: false
```

These values can be overridden per field via the `Select2Type` options.

---

## 8. Compatibility and asset strategy

- The bundle uses **classic vendoring**: JS/CSS files are embedded in the bundle and exposed via `assets:install`.
- **No dependency on Asset Mapper, npm or Node.js is required**.
- The bundle works with Symfony 5.x, 6.x, 7.x and earlier.

---

## 9. Update

To update the bundle and the JavaScript library:

```bash
composer update select2-vanilla/bundle celtic34fr/select2vanilla
php bin/console assets:install
```

---

## License

MIT
