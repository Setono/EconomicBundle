<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Entity;

use Symfony\Component\Uid\Uuid;

class Error
{
    protected string $id;

    protected string $message;

    public function __construct(string $message)
    {
        $this->id = (string) Uuid::v4();
        $this->message = $message;
    }
}
