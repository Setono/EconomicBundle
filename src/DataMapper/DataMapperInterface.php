<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DataMapper;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Resource\ResourceInterface;
use Spatie\DataTransferObject\DataTransferObject;

interface DataMapperInterface
{
    /**
     * Maps the $dto to an entity and returns that entity
     */
    public function map(ResourceInterface $resource, DataTransferObject $dto): EconomicAwareInterface;

    /**
     * Returns true if this mapper supports the given $resource and $dto
     */
    public function supports(ResourceInterface $resource, DataTransferObject $dto): bool;
}
