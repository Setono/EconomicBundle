<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Message\Handler;

use Doctrine\Persistence\ManagerRegistry;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Message\Command\PushEntityToEconomic;
use Setono\EconomicBundle\Pusher\EntityPusherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class PushEntityToEconomicHandler implements MessageHandlerInterface
{
    use ORMManagerTrait;

    private EntityPusherInterface $entityPusher;

    public function __construct(ManagerRegistry $managerRegistry, EntityPusherInterface $entityPusher)
    {
        $this->managerRegistry = $managerRegistry;
        $this->entityPusher = $entityPusher;
    }

    public function __invoke(PushEntityToEconomic $message): void
    {
        $manager = $this->getManager($message->getClass());

        $obj = $manager->find($message->getClass(), $message->getIdentifier());

        if (!$obj instanceof EconomicAwareInterface) {
            return; // todo should this be logged?
        }

        $this->entityPusher->pushEntity($obj);
    }
}
