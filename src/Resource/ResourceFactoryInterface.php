<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource;

use Spatie\DataTransferObject\DataTransferObject;

interface ResourceFactoryInterface
{
    /**
     * @param class-string<DataTransferObject> $dto the DTO class-string
     */
    public function create(string $name, string $baseUri, string $identifier, string $dto): ResourceInterface;
}
