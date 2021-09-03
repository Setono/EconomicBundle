<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\Resolver;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Resource\ResourceInterface;

interface ResolverInterface
{
    public function resolveEndpoint(EconomicAwareInterface $entity): ResourceInterface;
}
