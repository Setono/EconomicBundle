<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource;

/**
 * This class represents a resource config
 */
final class Config
{
    private string $entity;

    private bool $pushEnabled;

    private bool $pullEnabled;

    public function __construct(string $entity, bool $push, bool $pull)
    {
        $this->entity = $entity;
        $this->pushEnabled = $push;
        $this->pullEnabled = $pull;
    }

    /**
     * The entity class that a resource is mapped to
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * Whether this entity should be pushed to e-conomic on changes
     */
    public function isPushEnabled(): bool
    {
        return $this->pushEnabled;
    }

    /**
     * Whether changes from e-conomic should synced to the local database
     */
    public function isPullEnabled(): bool
    {
        return $this->pullEnabled;
    }
}
