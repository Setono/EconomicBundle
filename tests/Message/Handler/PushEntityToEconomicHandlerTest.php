<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Tests\Message\Handler;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\EconomicBundle\Message\Command\PushEntityToEconomic;
use Setono\EconomicBundle\Message\Handler\PushEntityToEconomicHandler;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

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
        $class = new class() {
            /** @Groups("setono:economic:push") */
            public int $id = 123;

            /** @Groups("setono:economic:push") */
            public string $name = 'Entity name';

            public string $secret = 'Secret';
        };

        $manager = $this->prophesize(EntityManagerInterface::class);
        $manager->find('Entity', 123)->willReturn($class);

        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry->getManagerForClass('Entity')->willReturn($manager);

        $handler = new PushEntityToEconomicHandler($managerRegistry->reveal(), self::getSerializer());
        $handler->__invoke(new PushEntityToEconomic(123, 'Entity'));
    }

    private static function getSerializer(): SerializerInterface
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer($classMetadataFactory)];

        return new Serializer($normalizers, $encoders);
    }
}
