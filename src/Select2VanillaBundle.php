<?php

namespace Select2VanillaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class Select2VanillaBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $container): void
    {
        // La configuration de l'asset_mapper doit être faite manuellement dans config/packages/framework.yaml
        // (méthode prependExtensionConfig() supprimée dans Symfony 8.x)
    }
}
