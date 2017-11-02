<?php

namespace Keboola\Processor\AddRowNumberColumn;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigDefinition implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root("parameters");

        $rootNode
            ->children()
                ->scalarNode("column_name")
                    ->defaultValue("row_number")
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
