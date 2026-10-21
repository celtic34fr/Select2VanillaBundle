<?php

namespace Select2VanillaBundle;

use Composer\InstalledVersions;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class Select2VanillaBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $container): void
    {
        if (!interface_exists('Symfony\Component\AssetMapper\AssetMapperInterface')) {
            return;
        }

        $installPath = InstalledVersions::getInstallPath('celtic34fr/select2vanilla');
        if (!$installPath) {
            return;
        }

        $configurator->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => [
                    $installPath . '/src' => 'select2vanilla',
                ],
            ],
        ]);
    }
}
