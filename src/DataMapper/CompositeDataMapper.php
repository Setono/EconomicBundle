<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DataMapper;

use Setono\EconomicBundle\Entity\EconomicAwareInterface;
use Setono\EconomicBundle\Resource\ResourceInterface;
use Spatie\DataTransferObject\DataTransferObject;

final class CompositeDataMapper implements DataMapperInterface
{
    /** @var array<array-key, DataMapperInterface> */
    private array $mappers = [];

    public function add(DataMapperInterface $dataMapper): void
    {
        $this->mappers[] = $dataMapper;
    }

    public function map(ResourceInterface $resource, DataTransferObject $dto): EconomicAwareInterface
    {
        foreach ($this->mappers as $mapper) {
            if ($mapper->supports($resource, $dto)) {
                return $mapper->map($resource, $dto);
            }
        }

        throw new \RuntimeException(sprintf('No mappers support the resource %s and the DTO %s', $resource->getName(), get_class($dto)));
    }

    public function supports(ResourceInterface $resource, DataTransferObject $dto): bool
    {
        foreach ($this->mappers as $mapper) {
            if ($mapper->supports($resource, $dto)) {
                return true;
            }
        }

        return false;
    }
}
