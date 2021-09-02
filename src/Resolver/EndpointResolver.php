<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resolver;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;

final class EndpointResolver implements EndpointResolverInterface
{
    public function getSingle(EconomicAwareInterface $entity, string $identifier): string
    {
        return sprintf('/customers/%s', $identifier); // todo dummy
    }

    public function postSingle(EconomicAwareInterface $entity): string
    {
        return sprintf('/customers'); // todo dummy
    }

    public function putSingle(EconomicAwareInterface $entity, string $identifier): string
    {
        return sprintf('/customers/%s', $identifier); // todo dummy
    }
}
