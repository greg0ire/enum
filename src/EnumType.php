<?php

declare(strict_types=1);

namespace Greg0ire\Enum;

final class EnumType
{
    public const ENUM_INT = 1;
    public const ENUM_STRING = 2;
    public const ENUM_BOOL = 4;
    public const ENUM_ARRAY = 8;
    public const ENUM_ALL = self::ENUM_INT + self::ENUM_STRING + self::ENUM_BOOL + self::ENUM_ARRAY;
}
