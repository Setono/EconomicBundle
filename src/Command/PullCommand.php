<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Command;

use Setono\EconomicBundle\Message\Command\PullCollectionFromEconomic;
use Setono\EconomicBundle\Resource\Registry\RegistryInterface;
use Setono\EconomicBundle\Resource\ResourceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

final class PullCommand extends Command
{
    protected static $defaultName = 'setono:economic:pull';

    protected static $defaultDescription = 'Pull configured resources from e-conomic to your local database';

    private RegistryInterface $resourceRegistry;

    private MessageBusInterface $commandBus;

    public function __construct(RegistryInterface $resourceRegistry, MessageBusInterface $commandBus)
    {
        parent::__construct();

        $this->resourceRegistry = $resourceRegistry;
        $this->commandBus = $commandBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->section('Starting synchronization (pull) of e-conomic resources to local database');

        /** @var ResourceInterface $resource */
        foreach ($this->resourceRegistry as $resource) {
            $config = $resource->getConfig();
            if (null === $config) {
                $io->info(sprintf('No config for resource %s', $resource->getName()));

                continue;
            }

            if (!$config->isPullEnabled()) {
                $io->info(sprintf('Pulling is not enabled for resource %s', $resource->getName()));

                continue;
            }

            $io->success(sprintf('Triggered pull of collection for resource %s', $resource->getName()));
            $this->commandBus->dispatch(new PullCollectionFromEconomic($resource));
        }

        return Command::SUCCESS;
    }
}
