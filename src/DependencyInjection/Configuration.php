<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DependencyInjection;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_economic');
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
                    ->isRequired()
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
                ->arrayNode('resources')
                    ->info('Configure the pushing and pulling of resources to e-conomic')
                    ->useAttributeAsKey('resource')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('resource')
                                ->isRequired()
                            ->end()
                            ->scalarNode('entity')
                                ->isRequired()
                                ->validate()
                                    ->ifTrue(fn (string $class) => !is_a($class, EconomicAwareInterface::class, true))
                                    ->thenInvalid(sprintf('The entity must implement the %s', EconomicAwareInterface::class))
                                ->end()
                            ->end()
                            ->booleanNode('push')
                                ->defaultFalse()
                            ->end()
                            ->booleanNode('pull')
                                ->defaultFalse()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
