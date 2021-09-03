<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\DTO;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

final class VatZoneDTO extends FlexibleDataTransferObject
{
    public int $vatZoneNumber;
}
