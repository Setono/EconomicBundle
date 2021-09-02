<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Endpoint;

interface EndpointInterface
{
    /**
     * Returns a unique (within endpoints) string that identifies the endpoint.
     * An example could be 'customer'
     *
     * This is used to map between entities and endpoints
     */
    public function getResource(): string;

    /**
     * The base uri that all urls on this endpoint are built from.
     * An example could be '/customers'
     */
    public function getBaseUri(): string;

    /**
     * This is the property on the endpoint that identifies a resource of this kind within e-conomic.
     * An example could be 'customerNumber' which identifies customers
     */
    public function getIdentifier(): string;
}
