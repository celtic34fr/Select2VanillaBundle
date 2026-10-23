<?php

declare(strict_types=1);

/*
 * Synchronise les assets navigateur du bundle depuis la librairie
 * celtic34fr/select2vanilla.
 *
 * Usage :
 *   php bin/sync-assets.php [chemin/vers/select2vanilla/src]
 *
 * Sans argument, le script utilise vendor/celtic34fr/select2vanilla/src.
 * La librairie est un module ES (export default) ; la copie du bundle est un
 * script classique, on retire donc uniquement la ligne d'export.
 */

$root = dirname(__DIR__);
$source = $argv[1] ?? $root . '/vendor/celtic34fr/select2vanilla/src';
$target = $root . '/public';

$jsSource = $source . '/select2vanilla.js';
$cssSource = $source . '/select2vanilla.css';

foreach ([$jsSource, $cssSource] as $file) {
    if (!is_file($file)) {
        fwrite(STDERR, sprintf("Fichier source introuvable : %s\n", $file));
        exit(1);
    }
}

foreach ([$target . '/js', $target . '/css'] as $dir) {
    if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
        fwrite(STDERR, sprintf("Impossible de créer le dossier : %s\n", $dir));
        exit(1);
    }
}

$js = file_get_contents($jsSource);
if (false === $js) {
    fwrite(STDERR, sprintf("Impossible de lire : %s\n", $jsSource));
    exit(1);
}

$js = preg_replace('/^\s*export default Select2Vanilla;\s*$/m', '', $js);

if (false === file_put_contents($target . '/js/select2vanilla.js', $js)) {
    fwrite(STDERR, "Impossible d'écrire public/js/select2vanilla.js\n");
    exit(1);
}

if (!copy($cssSource, $target . '/css/select2vanilla.css')) {
    fwrite(STDERR, "Impossible d'écrire public/css/select2vanilla.css\n");
    exit(1);
}

echo sprintf("Assets synchronisés depuis %s\n", $source);
