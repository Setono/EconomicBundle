<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Tests\Message\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Message\Command\PushEntityToEconomic;
use Setono\EconomicBundle\Message\Handler\PushEntityToEconomicHandler;
use Setono\EconomicBundle\Pusher\EntityPusherInterface;

/**
 * @covers \Setono\EconomicBundle\Message\Handler\PushEntityToEconomicHandler
 */
final class PushEntityToEconomicHandlerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_pushes_entity(): void
    {
        $entity = new EconomicAware();
        $class = get_class($entity);

        $manager = $this->prophesize(EntityManagerInterface::class);
        $manager->find($class, 123)->willReturn($entity);

        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass($class)->willReturn($manager);

        $pusher = $this->prophesize(EntityPusherInterface::class);
        $pusher->pushEntity($entity)->shouldBeCalled();

        $handler = new PushEntityToEconomicHandler($managerRegistry->reveal(), $pusher->reveal());
        $handler->__invoke(new PushEntityToEconomic(123, $class));
    }
}

class EconomicAware implements EconomicAwareInterface
{
    public function getEconomicIdentifier(): ?string
    {
        return 'identifier';
    }

    public function setEconomicIdentifier(?string $identifier): void
    {
        // TODO: Implement setEconomicIdentifier() method.
    }
}
