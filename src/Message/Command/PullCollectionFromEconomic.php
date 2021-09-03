<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Message\Command;

use Setono\EconomicBundle\Resource\ResourceInterface;
use Webmozart\Assert\Assert;

final class PullCollectionFromEconomic
{
    private string $resource;

    /**
     * @param string|ResourceInterface|mixed $resource
     */
    public function __construct($resource)
    {
        if ($resource instanceof ResourceInterface) {
            $resource = $resource->getName();
        }
        Assert::string($resource);

        $this->resource = $resource;
    }

    public function getResource(): string
    {
        return $this->resource;
    }
}
