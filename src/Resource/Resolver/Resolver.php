<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\Resolver;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Resource\Registry\RegistryInterface;
use Setono\EconomicBundle\Resource\ResourceInterface;

final class Resolver implements ResolverInterface
{
    private RegistryInterface $resourceRegistry;

    public function __construct(RegistryInterface $endpointRegistry)
    {
        $this->resourceRegistry = $endpointRegistry;
    }

    public function resolveEndpoint(EconomicAwareInterface $entity): ResourceInterface
    {
        $entityClass = get_class($entity);

        /** @var ResourceInterface $resource */
        foreach ($this->resourceRegistry as $resource) {
            $config = $resource->getConfig();
            if (null === $config) {
                continue;
            }

            if ($config->getEntity() !== $entityClass) {
                continue;
            }

            return $resource;
        }

        throw new \RuntimeException(sprintf('Could not resolve $entity (%s) to any resource', get_class($entity)));
    }
}
