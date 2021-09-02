<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resolver;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;

interface EndpointResolverInterface
{
    /**
     * Returns the GET endpoint for GETting a single resource
     */
    public function getSingle(EconomicAwareInterface $entity, string $identifier): string;

    /**
     * Returns the POST endpoint for POSTing a single resource
     */
    public function postSingle(EconomicAwareInterface $entity): string;

    /**
     * Returns the PUT endpoint for PUTting a single resource
     */
    public function putSingle(EconomicAwareInterface $entity, string $identifier): string;
}
