<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\DTO;

use Setono\EconomicBundle\Resource\DTO\CustomerDTO\CustomerGroupDTO;
use Setono\EconomicBundle\Resource\DTO\CustomerDTO\PaymentTermsDTO;
use Setono\EconomicBundle\Resource\DTO\CustomerDTO\VatZoneDTO;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

final class CustomerDTO extends FlexibleDataTransferObject
{
    use DataTransferObjectTrait;

    public ?int $customerNumber = null;

    public ?string $name = null;

    public ?string $address = null;

    public ?string $zip = null;

    public ?string $city = null;

    public ?string $country = null;

    public ?string $corporateIdentificationNumber = null;

    public ?string $email = null;

    public string $currency;

    public ?float $balance = null;

    public ?float $dueAmount = null;

    public ?bool $eInvoicingDisabledByDefault = null;

    public PaymentTermsDTO $paymentTerms;

    public CustomerGroupDTO $customerGroup;

    public VatZoneDTO $vatZone;

    public ?\DateTimeImmutable $lastUpdated = null;
}
