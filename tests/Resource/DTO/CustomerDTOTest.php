<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Tests\Resource\DTO;

use PHPUnit\Framework\TestCase;
use Setono\EconomicBundle\Resource\DTO\CustomerDTO;
use Webmozart\Assert\Assert;

/**
 * @covers \Setono\EconomicBundle\Resource\DTO\CustomerDTO
 */
final class CustomerDTOTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $data = self::getData();
        new CustomerDTO($data);

        self::assertTrue(true);
    }

    private static function getData(): array
    {
        $json = <<<DATA
{
    "customerNumber": 1,
    "currency": "DKK",
    "paymentTerms": {
        "paymentTermsNumber": 1,
        "self": "https://restapi.e-conomic.com/payment-terms/1"
    },
    "customerGroup": {
        "customerGroupNumber": 1,
        "self": "https://restapi.e-conomic.com/customer-groups/1"
    },
    "address": "Vejen 1",
    "balance": 32608518.73,
    "dueAmount": 32577233.93,
    "corporateIdentificationNumber": "DK12345678",
    "city": "Storeby",
    "country": "Denmark",
    "email": "jo+billing@addwish.com",
    "name": "Addwish Company",
    "zip": "1234",
    "vatZone": {
        "vatZoneNumber": 1,
        "self": "https://restapi.e-conomic.com/vat-zones/1"
    },
    "lastUpdated": "2021-09-03T08:15:57Z",
    "contacts": "https://restapi.e-conomic.com/customers/1/contacts",
    "templates": {
        "invoice": "https://restapi.e-conomic.com/customers/1/templates/invoice",
        "invoiceLine": "https://restapi.e-conomic.com/customers/1/templates/invoiceline",
        "self": "https://restapi.e-conomic.com/customers/1/templates"
    },
    "totals": {
        "drafts": "https://restapi.e-conomic.com/invoices/totals/drafts/customers/1",
        "booked": "https://restapi.e-conomic.com/invoices/totals/booked/customers/1",
        "self": "https://restapi.e-conomic.com/customers/1/totals"
    },
    "deliveryLocations": "https://restapi.e-conomic.com/customers/1/delivery-locations",
    "invoices": {
        "drafts": "https://restapi.e-conomic.com/customers/1/invoices/drafts",
        "booked": "https://restapi.e-conomic.com/customers/1/invoices/booked",
        "self": "https://restapi.e-conomic.com/customers/1/invoices"
    },
    "eInvoicingDisabledByDefault": false,
    "self": "https://restapi.e-conomic.com/customers/1"
}
DATA;

        $data = json_decode($json, true, 512, \JSON_THROW_ON_ERROR);
        Assert::isArray($data);

        return $data;
    }
}
