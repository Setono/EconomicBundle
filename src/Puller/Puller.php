<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Puller;

use Setono\EconomicBundle\Client\ClientInterface;
use Setono\EconomicBundle\Message\Command\PullCollectionPageFromEconomic;
use Setono\EconomicBundle\Resource\ResourceInterface;
use Setono\JobStatusBundle\Factory\JobFactoryInterface;
use Setono\JobStatusBundle\Manager\JobManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class Puller implements PullerInterface
{
    private ClientInterface $client;

    private JobManagerInterface $jobManager;

    private JobFactoryInterface $jobFactory;

    private MessageBusInterface $commandBus;

    public function __construct(
        ClientInterface $client,
        JobManagerInterface $jobManager,
        JobFactoryInterface $jobFactory,
        MessageBusInterface $commandBus
    ) {
        $this->client = $client;
        $this->jobManager = $jobManager;
        $this->jobFactory = $jobFactory;
        $this->commandBus = $commandBus;
    }

    public function pullCollection(ResourceInterface $resource): void
    {
        $config = $resource->getConfig();
        if (null === $config || !$config->isPullEnabled()) {
            return;
        }

        $pageSize = 100;
        $urlBuilder = $this->client->createUrlBuilder()->endpoint($resource->getBaseUri())->pageSize($pageSize);
        $pageCount = $this->client->getPageCount($urlBuilder->build());

        $job = $this->jobFactory->createNew();
        $job->setName(sprintf('E-conomic: Pull %s collection', $resource->getName()));
        $job->setExclusive(true);
        $job->setType(sprintf('pull_%s_collection', $resource->getName()));
        $job->setSteps($pageCount);

        $this->jobManager->start($job);

        for ($page = 1; $page <= $pageCount; ++$page) {
            $this->commandBus->dispatch(new PullCollectionPageFromEconomic($resource, $job, $urlBuilder->skipPages($page - 1)->build()));
        }
    }
}
