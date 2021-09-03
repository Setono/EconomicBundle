<?php

declare(strict_types=1);

namespace Setono\EconomicBundle\Resource\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\FieldValidator;
use Spatie\DataTransferObject\ValueCaster;

/**
 * @mixin DataTransferObject
 */
trait DataTransferObjectTrait
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function castValue(ValueCaster $valueCaster, FieldValidator $fieldValidator, $value)
    {
        /** @var mixed $value */
        $value = parent::castValue($valueCaster, $fieldValidator, $value);
        if (is_string($value)) {
            $date = \DateTimeImmutable::createFromFormat(\DATE_ATOM, $value);
            if (false !== $date) {
                $value = $date;
            }
        }

        return $value;
    }
}
