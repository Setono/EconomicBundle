<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource;

interface ResourceFactoryInterface
{
    public function create(string $name, string $baseUri, string $identifier): ResourceInterface;
}
