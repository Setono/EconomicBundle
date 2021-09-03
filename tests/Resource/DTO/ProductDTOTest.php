<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Tests\Resource\DTO;

use PHPUnit\Framework\TestCase;
use Setono\EconomicBundle\Resource\DTO\ProductDTO;
use Webmozart\Assert\Assert;

/**
 * @covers \Setono\EconomicBundle\Resource\DTO\ProductDTO
 */
final class ProductDTOTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates(): void
    {
        $data = self::getData();
        new ProductDTO($data);

        self::assertTrue(true);
    }

    private static function getData(): array
    {
        $json = <<<DATA
{
    "productNumber": "1",
    "description": "Skånsom vask af skjorte. Metode: 30 graders vask Anvisning: (P) (Vask) Miljøkrav: Svanemærket.",
    "name": "Skjorte",
    "recommendedPrice": 0.00,
    "salesPrice": 0.00,
    "barred": false,
    "lastUpdated": "2019-10-29T09:26:00Z",
    "productGroup": {
        "productGroupNumber": 1,
        "name": "Varer m/moms",
        "salesAccounts": "https://restapi.e-conomic.com/product-groups/1/sales-accounts",
        "products": "https://restapi.e-conomic.com/product-groups/1/products",
        "self": "https://restapi.e-conomic.com/product-groups/1"
    },
    "unit": {
        "unitNumber": 1,
        "name": "stk.",
        "products": "https://restapi.e-conomic.com/units/1/products",
        "self": "https://restapi.e-conomic.com/units/1"
    },
    "inventory": {
        "available": 0.0,
        "inStock": 0.0,
        "orderedFromSuppliers": 0.0,
        "orderedByCustomers": 0.0,
        "packageVolume": 0.00,
        "recommendedCostPrice": 0.00
    },
    "invoices": {
        "drafts": "https://restapi.e-conomic.com/products/1/invoices/drafts",
        "booked": "https://restapi.e-conomic.com/products/1/invoices/booked",
        "self": "https://restapi.e-conomic.com/products/1/invoices"
    },
    "pricing": {
        "currencySpecificSalesPrices": "https://restapi.e-conomic.com/products/1/pricing/currency-specific-sales-prices"
    },
    "self": "https://restapi.e-conomic.com/products/1"
}
DATA;

        $data = json_decode($json, true, 512, \JSON_THROW_ON_ERROR);
        Assert::isArray($data);

        return $data;
    }
}
