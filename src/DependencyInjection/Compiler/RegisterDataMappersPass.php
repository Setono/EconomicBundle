<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DependencyInjection\Compiler;

use Setono\EconomicBundle\DataMapper\DataMapperInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterDataMappersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('setono_economic.data_mapper.composite')) {
            return;
        }

        $mapper = $container->getDefinition('setono_economic.data_mapper.composite');

        /** @var string $id */
        foreach (array_keys($container->findTaggedServiceIds('setono_economic.data_mapper')) as $id) {
            $mapper->addMethodCall('add', [new Reference($id)]);
        }
    }
}
