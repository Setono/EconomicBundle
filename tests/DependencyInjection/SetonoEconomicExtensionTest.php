<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\EconomicBundle\DependencyInjection\SetonoEconomicExtension;

/**
 * @covers \Setono\EconomicBundle\DependencyInjection\SetonoEconomicExtension
 */
final class SetonoEconomicExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoEconomicExtension(),
        ];
    }

    /**
     * @test
     */
    public function it_can_load(): void
    {
        $this->load();

        self::assertTrue(true);
    }
}
