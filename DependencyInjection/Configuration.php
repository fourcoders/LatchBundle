<?php

namespace Fourcoders\Bundle\LatchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fourcoders_latch');
        $rootNode
            ->children()
                ->variableNode('latch_app_id')->isRequired()
                ->end()
                ->variableNode('latch_app_secret')->isRequired()
                ->end()
                ->variableNode('latch_driver')->isRequired()
                ->end()
                ->variableNode('latch_redirect')
                ->end()
                ->arrayNode('latch_operations')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('pattern')->isRequired()
                            ->end()
                            ->scalarNode('latch_operation')->isRequired()
                            ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
