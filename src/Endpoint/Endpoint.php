<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Endpoint;

final class Endpoint implements EndpointInterface
{
    private string $resource;

    private string $baseUri;

    private string $identifier;

    public function __construct(string $resource, string $baseUri, string $identifier)
    {
        $this->resource = $resource;
        $this->baseUri = rtrim($baseUri, '/');
        $this->identifier = $identifier;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
