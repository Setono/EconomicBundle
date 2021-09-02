<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\EventListener\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Message\Command\PushEntityToEconomic;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class EntityUpdatedListener
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function postPersist(LifecycleEventArgs $eventArgs): void
    {
        $this->handleUpdate($eventArgs);
    }

    public function postUpdate(LifecycleEventArgs $eventArgs): void
    {
        $this->handleUpdate($eventArgs);
    }

    private function handleUpdate(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();

        /**
         * todo this is a very simple check to see if the entity should be pushed to e-conomic. This should probably also be handled in the configuration of the bundle
         */
        if (!$entity instanceof EconomicAwareInterface) {
            return;
        }

        $classMetadata = $eventArgs->getObjectManager()->getClassMetadata(get_class($entity));
        $identifiers = $classMetadata->getIdentifier();
        Assert::count($identifiers, 1); // we don't support entities with composite keys at the moment
        Assert::allString($identifiers);

        $identifier = $identifiers[0];

        $values = $classMetadata->getIdentifierValues($entity);
        Assert::keyExists($values, $identifier);

        /** @var mixed $identifierValue */
        $identifierValue = $values[$identifier];

        $this->commandBus->dispatch(new PushEntityToEconomic($identifierValue, $entity));
    }
}
