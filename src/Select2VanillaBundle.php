<?php

namespace Select2VanillaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class Select2VanillaBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $container): void
    {
        // Configure automatiquement l'Asset Mapper pour exposer les assets JS/CSS du bundle.
        // Les fichiers sont servis sous le préfixe "select2vanilla" (ex: @select2vanilla/select2vanilla.js).
        $configurator->extension('framework', [
            'asset_mapper' => [
                'paths' => [
                    dirname(__DIR__, 1) . '/src/Resources/public' => 'select2vanilla',
                ],
            ],
        ]);
    }
}
