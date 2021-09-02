<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Endpoint\Registry;

use Setono\EconomicBundle\Endpoint\EndpointInterface;

interface RegistryInterface extends \Traversable
{
    public function add(EndpointInterface $endpoint): void;

    public function has(string $resource): bool;

    public function get(string $resource): EndpointInterface;
}
