<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_economic');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        /**
         * @psalm-suppress MixedMethodCall
         * @psalm-suppress PossiblyUndefinedMethod
         * @psalm-suppress PossiblyNullReference
         */
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('app_secret_token')
                            ->isRequired()
                            ->info('The token you get from the app developer')
                            ->example('demo')
                        ->end()
                        ->scalarNode('agreement_grant_token')
                            ->isRequired()
                            ->info('The token you get when you have granted access to the app to your e-conomic agreement')
                            ->example('demo')
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
