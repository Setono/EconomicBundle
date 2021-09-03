<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Puller;

use Setono\EconomicBundle\Resource\ResourceInterface;

interface PullerInterface
{
    public function pullCollection(ResourceInterface $resource): void;
}
