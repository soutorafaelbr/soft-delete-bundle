<?php
namespace Souto\SoftDeleteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('souto_soft_delete');

        $treeBuilder->getRootNode()
            ->children()
            ->arrayNode('prefix_route_disabled')
                ->info('The route prefix set here will be able to fetch all entities, ignoring the deleted_at attribute')
                ->beforeNormalization()->ifString()->then(function ($v) { return [$v]; })->end()
                ->prototype('scalar')->end()
            ->end();

        return $treeBuilder;
    }
}