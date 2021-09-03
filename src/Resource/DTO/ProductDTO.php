<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\DTO;

use Setono\EconomicBundle\Resource\DTO\ProductDTO\InventoryDTO;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

final class ProductDTO extends FlexibleDataTransferObject
{
    use DataTransferObjectTrait;

    public ?string $productNumber = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?float $recommendedPrice = null;

    public ?float $salesPrice = null;

    public ?bool $barred = null;

    public ?\DateTimeImmutable $lastUpdated = null;

    public ?InventoryDTO $inventory;
}
