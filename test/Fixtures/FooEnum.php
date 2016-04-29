<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\BaseEnum;

final class FooEnum extends BaseEnum
{
    protected static function getEnumTypes()
    {
        return array('Greg0ire\Enum\Tests\Fixtures\FooInterface');
    }
}
