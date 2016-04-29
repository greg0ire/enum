<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\BaseEnum;

final class DummyEnum extends BaseEnum
{
    const FIRST = 42,
        SECOND = 'some_value';
}
