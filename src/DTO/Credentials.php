<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DTO;

final class Credentials
{
    private string $appSecretToken;

    private string $agreementGrantToken;

    public function __construct(string $appSecretToken, string $agreementGrantToken)
    {
        $this->appSecretToken = $appSecretToken;
        $this->agreementGrantToken = $agreementGrantToken;
    }

    public function getAppSecretToken(): string
    {
        return $this->appSecretToken;
    }

    public function getAgreementGrantToken(): string
    {
        return $this->agreementGrantToken;
    }
}
