<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource;

use Spatie\DataTransferObject\DataTransferObject;

final class Resource implements ResourceInterface
{
    private string $name;

    private string $baseUri;

    private string $identifier;

    /** @var class-string<DataTransferObject> */
    private string $dto;

    private ?Config $config = null;

    /**
     * @param class-string<DataTransferObject> $dto
     */
    public function __construct(string $name, string $baseUri, string $identifier, string $dto)
    {
        $this->name = $name;
        $this->baseUri = rtrim($baseUri, '/');
        $this->identifier = $identifier;
        $this->dto = $dto;
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

    public function getDTO(): string
    {
        return $this->dto;
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
