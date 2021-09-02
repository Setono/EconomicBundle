<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoEconomicExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * @var array{credentials: array{app_secret_token: string, agreement_grant_token: string}, entity_mapping: array<string, string>} $config
         * @psalm-suppress PossiblyNullArgument
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $container->setParameter('setono_economic.credentials.app_secret_token', $config['credentials']['app_secret_token']);
        $container->setParameter('setono_economic.credentials.agreement_grant_token', $config['credentials']['agreement_grant_token']);
        $container->setParameter('setono_economic.entity_mapping', $config['entity_mapping']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
