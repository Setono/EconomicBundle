<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource;

final class ResourceFactory implements ResourceFactoryInterface
{
    private array $resourceConfigs;

    public function __construct(array $resourceConfigs)
    {
        $this->resourceConfigs = $resourceConfigs;
    }

    public function create(string $name, string $baseUri, string $identifier): ResourceInterface
    {
        $resource = new Resource($name, $baseUri, $identifier);

        foreach ($this->resourceConfigs as $resourceName => $resourceConfig) {
            if ($name !== $resourceName) {
                continue;
            }

            $config = new Config($resourceConfig['entity'], $resourceConfig['push'], $resourceConfig['pull']);
            $resource->setConfig($config);
        }

        return $resource;
    }
}
