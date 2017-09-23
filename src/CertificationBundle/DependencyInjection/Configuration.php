<?php


namespace CertificationBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treebuilder = new TreeBuilder();
        $rootnode = $treebuilder->root('certification');

        $rootnode
            ->children()
                ->arrayNode('sub')
                    ->children()
                        ->integerNode('integerValue')->end()
                        ->scalarNode('scalarValue')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treebuilder;
    }

}