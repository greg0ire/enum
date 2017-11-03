<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\AbstractEnum;

final class FooEnum extends AbstractEnum
{
    protected static function getEnumTypes(): array
    {
        return [FooInterface::class];
    }
}
