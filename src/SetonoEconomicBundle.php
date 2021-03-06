<?php

declare(strict_types=1);

namespace Setono\EconomicBundle;

use Setono\EconomicBundle\DependencyInjection\Compiler\RegisterDataMappersPass;
use Setono\EconomicBundle\DependencyInjection\Compiler\RegisterResourcesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoEconomicBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterResourcesPass());
        $container->addCompilerPass(new RegisterDataMappersPass());
    }
}
