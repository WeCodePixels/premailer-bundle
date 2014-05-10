<?php

namespace WeCodePixels\PremailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('we_code_pixels_premailer');

        $rootNode
            ->children()
            ->scalarNode('bin')
                ->defaultValue('/usr/local/bin/premailer')
                ->info('The path to the Premailer binary.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
