<?php

namespace Greg0ire\Enum\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Marcin Klimek <marcin.r.k@o2.pl>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('greg0ire_enum');

        $rootNode
            ->children()
                ->booleanNode('use_translator')
                    ->info("Defaults to true if translator is enabled. Set to false to prevent strings from being translated.")
                    ->defaultTrue()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
