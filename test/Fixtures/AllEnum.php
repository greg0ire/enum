<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\AbstractEnum;

final class AllEnum extends AbstractEnum
{
    protected static function getEnumTypes()
    {
        return [
            'originally' => 'Greg0ire\Enum\Tests\Fixtures\FooInterface',
            'Greg0ire\Enum\Tests\Fixtures\DummyEnum',
        ];
    }
}
