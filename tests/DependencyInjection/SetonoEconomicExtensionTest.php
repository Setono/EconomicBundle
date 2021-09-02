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

    protected function getMinimalConfiguration(): array
    {
        return [
            'credentials' => [
                'app_secret_token' => '4pp_$3cr37_70k3n',
                'agreement_grant_token' => '4gr33m3n7_gr4n7_70k3n',
            ]
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
