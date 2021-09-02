<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Endpoint\Resolver;

use Setono\EconomicBundle\Endpoint\EndpointInterface;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;

interface ResolverInterface
{
    public function resolveEndpoint(EconomicAwareInterface $entity): EndpointInterface;
}
