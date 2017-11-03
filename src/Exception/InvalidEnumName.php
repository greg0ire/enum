<?php

namespace Greg0ire\Enum\Exception;

final class InvalidEnumName extends \UnexpectedValueException
{
    public static function fromName(string $name, array $supportedNames): self
    {
        throw new self(sprintf(
            '"%s" is not a valid name, valid names are: ("%s")',
            $name,
            implode('", "', $supportedNames)
        ));
    }
}
