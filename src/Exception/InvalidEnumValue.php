<?php

namespace Greg0ire\Enum\Exception;

final class InvalidEnumValue extends \UnexpectedValueException
{
    public static function fromValue(string $value, array $supportedValues): self
    {
        throw new self(sprintf(
            '"%s" is not a valid value, valid values are: ("%s")',
            $value,
            implode('", "', $supportedValues)
        ));
    }
}
