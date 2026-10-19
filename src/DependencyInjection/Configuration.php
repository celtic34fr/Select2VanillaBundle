<?php

namespace Select2VanillaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('select2_vanilla');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('remove_icon_html')->defaultValue('×')->info('HTML inséré dans le bouton de suppression (ex: &times; ou <i class="fa fa-times"></i>)')->end()
                ->scalarNode('placeholder')->defaultValue('Choisir ou saisir')->info('Placeholder par défaut du champ')->end()
                ->booleanNode('multiple')->defaultFalse()->info('Mode sélection multiple par défaut')->end()
            ->end();

        return $treeBuilder;
    }
}
