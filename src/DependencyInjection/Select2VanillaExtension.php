<?php

namespace Select2VanillaBundle\DependencyInjection;

use Composer\InstalledVersions;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Select2VanillaExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('select2_vanilla.remove_icon_html', $config['remove_icon_html']);
        $container->setParameter('select2_vanilla.placeholder', $config['placeholder']);
        $container->setParameter('select2_vanilla.multiple', $config['multiple']);

        // Chemin vers les assets JS/CSS de select2vanilla dans vendor/
        $installPath = InstalledVersions::getInstallPath('celtic34fr/select2vanilla');
        if ($installPath) {
            $container->setParameter('select2_vanilla.asset_path', $installPath . '/src');
        }

        // Préconfiguration best-effort de AssetMapper (si disponible)
        if ($installPath && interface_exists('Symfony\Component\AssetMapper\AssetMapperInterface')) {
            $container->prependExtensionConfig('framework', [
                'asset_mapper' => [
                    'paths' => [
                        $installPath . '/src' => 'select2vanilla',
                    ],
                ],
            ]);
        }

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}
