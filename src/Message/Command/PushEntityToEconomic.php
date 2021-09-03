<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Message\Command;

use Webmozart\Assert\Assert;

final class PushEntityToEconomic
{
    /** @var int|string */
    private $identifier;

    /** @var class-string */
    private string $class;

    /**
     * @param int|string|mixed $identifier
     * @param class-string|object|mixed $class
     */
    public function __construct($identifier, $class)
    {
        if (!is_string($identifier) && !is_int($identifier)) {
            throw new \InvalidArgumentException(sprintf('The $identifier needs to be either int or string, "%s" provided', gettype($identifier)));
        }

        if (is_object($class)) {
            $class = get_class($class);
        }
        Assert::string($class);
        Assert::classExists($class);

        $this->identifier = $identifier;
        $this->class = $class;
    }

    /**
     * @return int|string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return class-string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}
