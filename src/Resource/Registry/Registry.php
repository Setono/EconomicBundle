<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\Registry;

use Setono\EconomicBundle\Resource\ResourceInterface;

final class Registry implements RegistryInterface, \IteratorAggregate
{
    /** @var array<array-key, ResourceInterface> */
    private array $resources = [];

    public function add(ResourceInterface $resource): void
    {
        if ($this->has($resource->getName())) {
            throw new \InvalidArgumentException(sprintf('A resource with name "%s" already exists', $resource->getName()));
        }

        $this->resources[] = $resource;
    }

    public function has(string $name): bool
    {
        return isset($this->resources[$name]);
    }

    public function get(string $name): ResourceInterface
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException(sprintf('A resource with name "%s" does not exist', $name));
        }

        return $this->resources[$name];
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->resources);
    }
}
