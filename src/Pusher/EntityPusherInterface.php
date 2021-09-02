<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Pusher;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;

interface EntityPusherInterface
{
    /**
     * Pushes the given $entity to e-conomic
     */
    public function pushEntity(EconomicAwareInterface $entity): void;
}
