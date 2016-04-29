<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\BaseEnum;

final class AllEnum extends BaseEnum
{
    protected static function getEnumTypes()
    {
        return array(
            'originally' => 'Greg0ire\Enum\Tests\Fixtures\FooInterface',
            'Greg0ire\Enum\Tests\Fixtures\DummyEnum',
        );
    }
}
