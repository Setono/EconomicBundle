<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Entity;

/**
 * Implement this interface on entities that should synchronize (push/pull) with e-conomic
 */
interface EconomicAwareInterface
{
    /**
     * Gets the value of the e-conomic identifier
     */
    public function getEconomicIdentifier(): ?string;

    /**
     * Sets the value of the e-conomic identifier
     */
    public function setEconomicIdentifier(?string $identifier): void;
}
