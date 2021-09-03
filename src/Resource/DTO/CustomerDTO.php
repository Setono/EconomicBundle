<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\DTO;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Symfony\Component\Intl\Countries;
use Webmozart\Assert\Assert;

final class CustomerDTO extends FlexibleDataTransferObject
{
    use DataTransferObjectTrait;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);

        if (null !== $this->country) {
            $names = Countries::getNames('en');
            $key = array_search($this->country, $names, true);
            Assert::string($key, sprintf('Invalid country: %s', $this->country));
            $this->country = $key;
        }
    }

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
