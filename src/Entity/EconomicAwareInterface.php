<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Entity;

/**
 * Implement this interface on entities that should synchronize (push/pull) with e-conomic
 */
interface EconomicAwareInterface
{
    /**
     * If this is true the push listener will not try to push this entity to economic
     */
    public function isPushListenerSkipped(): bool;

    public function skipPushListener(bool $skipPushListener = true): void;

    /**
     * Gets the value of the e-conomic identifier
     *
     * @return int|string|null
     */
    public function getEconomicIdentifier();

    /**
     * Sets the value of the e-conomic identifier
     *
     * @param int|string|null $identifier
     */
    public function setEconomicIdentifier($identifier): void;
}
