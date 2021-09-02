<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Endpoint\Registry;

use Setono\EconomicBundle\Endpoint\EndpointInterface;

final class Registry implements RegistryInterface, \IteratorAggregate
{
    /** @var array<array-key, EndpointInterface> */
    private array $endpoints = [];

    public function add(EndpointInterface $endpoint): void
    {
        if ($this->has($endpoint->getResource())) {
            throw new \InvalidArgumentException(sprintf('An endpoint with resource "%s" already exists', $endpoint->getResource()));
        }

        $this->endpoints[] = $endpoint;
    }

    public function has(string $resource): bool
    {
        return isset($this->endpoints[$resource]);
    }

    public function get(string $resource): EndpointInterface
    {
        if (!$this->has($resource)) {
            throw new \InvalidArgumentException(sprintf('An endpoint with resource "%s" does not exist', $resource));
        }

        return $this->endpoints[$resource];
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->endpoints);
    }
}
