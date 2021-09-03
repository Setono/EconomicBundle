<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Message\Handler;

use Setono\EconomicBundle\Message\Command\PullCollectionFromEconomic;
use Setono\EconomicBundle\Puller\PullerInterface;
use Setono\EconomicBundle\Resource\Registry\RegistryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class PullCollectionFromEconomicHandler implements MessageHandlerInterface
{
    private PullerInterface $puller;

    private RegistryInterface $resourceRegistry;

    public function __construct(PullerInterface $puller, RegistryInterface $resourceRegistry)
    {
        $this->puller = $puller;
        $this->resourceRegistry = $resourceRegistry;
    }

    public function __invoke(PullCollectionFromEconomic $message): void
    {
        if (!$this->resourceRegistry->has($message->getResource())) {
            return;
        }

        $resource = $this->resourceRegistry->get($message->getResource());
        $config = $resource->getConfig();
        if (null === $config || !$config->isPullEnabled()) {
            return;
        }

        $this->puller->pullCollection($resource);
    }
}
