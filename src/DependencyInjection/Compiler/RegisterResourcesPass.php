<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterResourcesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('setono_economic.resource.registry')) {
            return;
        }

        $registry = $container->getDefinition('setono_economic.resource.registry');

        foreach (array_keys($container->findTaggedServiceIds('setono_economic.resource')) as $id) {
            $registry->addMethodCall('add', [new Reference($id)]);
        }
    }
}
