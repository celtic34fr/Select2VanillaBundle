<?php

namespace Select2VanillaBundle\DependencyInjection;

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

        // Chemin vers les assets JS/CSS publics du bundle (src/Resources/public)
        $bundleDir = dirname(__DIR__, 1);
        $publicDir = $bundleDir . '/src/Resources/public';
        $container->setParameter('select2_vanilla.asset_path', $publicDir);
        $container->setParameter('select2_vanilla.css_path', $publicDir . '/css/select2vanilla.css');
        $container->setParameter('select2_vanilla.js_path', $publicDir . '/js/select2vanilla.js');
        $container->setParameter('select2_vanilla.init_js_path', $publicDir . '/js/select2-vanilla-init.js');

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}
