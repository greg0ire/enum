<?php

namespace Greg0ire\Enum\Exception;

final class InvalidEnumValue extends \UnexpectedValueException
{
    public static function fromValue($value, array $supportedValues)
    {
        throw new self(sprintf(
            '"%s" is not a valid value, valid values are: ("%s")',
            $value,
            implode('", "', $supportedValues)
        ));
    }
}
