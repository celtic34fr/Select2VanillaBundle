<?php

namespace Select2VanillaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class Select2VanillaBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $container): void
    {
        // Asset Mapper est optionnel : on ne déclare le mapping que si le
        // composant est installé dans le projet hôte.
        if (class_exists(\Symfony\Component\AssetMapper\AssetMapper::class)) {
            $configurator->extension('framework', [
                'asset_mapper' => [
                    'paths' => [
                        dirname(__DIR__) . '/public' => 'select2vanilla',
                    ],
                ],
            ]);
        }

        // Le thème de formulaire du bundle est enregistré automatiquement :
        // le projet hôte n'a plus besoin de le redéclarer.
        $configurator->extension('twig', [
            'form_themes' => [
                '@Select2Vanilla/Form/fields.html.twig',
            ],
        ]);
    }
}
