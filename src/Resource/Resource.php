<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource;

final class Resource implements ResourceInterface
{
    private string $name;

    private string $baseUri;

    private string $identifier;

    private ?Config $config;

    public function __construct(string $name, string $baseUri, string $identifier)
    {
        $this->name = $name;
        $this->baseUri = rtrim($baseUri, '/');
        $this->identifier = $identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getConfig(): ?Config
    {
        return $this->config;
    }

    public function setConfig(?Config $config): void
    {
        $this->config = $config;
    }
}
