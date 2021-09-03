<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Entity;

/**
 * @mixin EconomicAwareInterface
 */
trait EconomicAwareTrait
{
    protected bool $pushListenerSkipped = false;

    /**
     * If this is true the push listener will not try to push this entity to economic
     */
    public function isPushListenerSkipped(): bool
    {
        return $this->pushListenerSkipped;
    }

    public function skipPushListener(bool $skipPushListener = true): void
    {
        $this->pushListenerSkipped = $skipPushListener;
    }
}
