<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\DTO;

final class Credentials
{
    private string $appSecretToken;

    private string $agreementGrantToken;

    private ?string $agreementNumber;

    public function __construct(string $appSecretToken, string $agreementGrantToken, string $agreementNumber = null)
    {
        $this->appSecretToken = $appSecretToken;
        $this->agreementGrantToken = $agreementGrantToken;
        $this->agreementNumber = $agreementNumber;
    }

    public function getAppSecretToken(): string
    {
        return $this->appSecretToken;
    }

    public function getAgreementGrantToken(): string
    {
        return $this->agreementGrantToken;
    }

    public function getAgreementNumber(): ?string
    {
        return $this->agreementNumber;
    }
}
