<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\EventListener\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Message\Command\PushEntityToEconomic;
use Setono\EconomicBundle\Resource\Resolver\ResolverInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class EntityUpdatedListener
{
    private MessageBusInterface $commandBus;

    private ResolverInterface $resourceResolver;

    public function __construct(MessageBusInterface $commandBus, ResolverInterface $resourceResolver)
    {
        $this->commandBus = $commandBus;
        $this->resourceResolver = $resourceResolver;
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
        $entityClass = get_class($entity);

        if (!$entity instanceof EconomicAwareInterface) {
            return;
        }

        try {
            $resource = $this->resourceResolver->resolveEndpoint($entity);
        } catch (\Throwable $e) {
            throw new \RuntimeException(sprintf(
                'You have implemented the %s, but have not created a resource config for the entity %s',
                EconomicAwareInterface::class,
                $entityClass
            ));
        }

        $config = $resource->getConfig();
        if (null === $config) {
            return;
        }

        if (!$config->isPushEnabled()) {
            return;
        }

        $classMetadata = $eventArgs->getObjectManager()->getClassMetadata($entityClass);
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
