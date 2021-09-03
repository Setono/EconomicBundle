<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\DTO\ProductDTO;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

final class InventoryDTO extends FlexibleDataTransferObject
{
    public ?float $available = null;

    public ?float $inStock = null;

    public ?float $orderedFromSuppliers = null;

    public ?float $orderedByCustomers = null;

    public ?float $packageVolume = null;

    public ?float $recommendedCostPrice = null;
}
