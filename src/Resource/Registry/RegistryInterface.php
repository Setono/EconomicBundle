<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\Registry;

use Setono\EconomicBundle\Resource\ResourceInterface;

interface RegistryInterface extends \Traversable
{
    public function add(ResourceInterface $resource): void;

    public function has(string $name): bool;

    public function get(string $name): ResourceInterface;
}
