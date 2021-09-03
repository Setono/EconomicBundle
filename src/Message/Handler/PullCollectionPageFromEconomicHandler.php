<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Message\Handler;

use Doctrine\Persistence\ManagerRegistry;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;
use Setono\EconomicBundle\Client\ClientInterface;
use Setono\EconomicBundle\DataMapper\DataMapperInterface;
use Setono\EconomicBundle\Message\Command\PullCollectionPageFromEconomic;
use Setono\EconomicBundle\Resource\Registry\RegistryInterface;
use Setono\JobStatusBundle\Manager\JobManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class PullCollectionPageFromEconomicHandler implements MessageHandlerInterface
{
    use ORMManagerTrait;

    private RegistryInterface $resourceRegistry;

    private ClientInterface $client;

    private JobManagerInterface $jobManager;

    private DataMapperInterface $dataMapper;

    public function __construct(
        RegistryInterface $resourceRegistry,
        ClientInterface $client,
        JobManagerInterface $jobManager,
        DataMapperInterface $dataMapper,
        ManagerRegistry $managerRegistry
    ) {
        $this->resourceRegistry = $resourceRegistry;
        $this->client = $client;
        $this->jobManager = $jobManager;
        $this->dataMapper = $dataMapper;
        $this->managerRegistry = $managerRegistry;
    }

    public function __invoke(PullCollectionPageFromEconomic $message): void
    {
        if (!$this->resourceRegistry->has($message->getResource())) {
            return;
        }

        $resource = $this->resourceRegistry->get($message->getResource());
        $config = $resource->getConfig();
        if (null === $config || !$config->isPullEnabled()) {
            return;
        }

        $data = $this->client->get($message->getUrl())->toArray();
        Assert::keyExists($data, 'collection');
        Assert::isArray($data['collection']);

        foreach ($data['collection'] as $item) {
            Assert::isArray($item);

            $dtoClass = $resource->getDTO();

            /** @psalm-suppress UnsafeInstantiation */
            $dto = new $dtoClass($item);

            $entity = $this->dataMapper->map($resource, $dto);

            $manager = $this->getManager($entity);
            $manager->persist($entity);
            $manager->flush();
        }

        $this->jobManager->advance($message->getJobId());
    }
}
