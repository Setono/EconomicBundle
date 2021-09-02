<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Endpoint\Resolver;

use Setono\EconomicBundle\Endpoint\EndpointInterface;
use Setono\EconomicBundle\Endpoint\Registry\RegistryInterface;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;

final class Resolver implements ResolverInterface
{
    private RegistryInterface $endpointRegistry;

    /** @var array<string, string> */
    private array $entityMapping;

    /**
     * @param array<string, string> $entityMapping
     */
    public function __construct(RegistryInterface $endpointRegistry, array $entityMapping)
    {
        $this->endpointRegistry = $endpointRegistry;
        $this->entityMapping = $entityMapping;
    }

    public function resolveEndpoint(EconomicAwareInterface $entity): EndpointInterface
    {
        // todo should probably be a mapper
        foreach ($this->entityMapping as $resource => $entityClass) {
            if (get_class($entity) !== $entityClass) {
                continue;
            }

            if ($this->endpointRegistry->has($resource)) {
                return $this->endpointRegistry->get($resource);
            }
        }

        throw new \RuntimeException(sprintf('Could not resolve $entity (%s) to any resource', get_class($entity)));
    }
}
