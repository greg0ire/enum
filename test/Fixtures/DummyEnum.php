<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\AbstractEnum;

final class DummyEnum extends AbstractEnum
{
    const FIRST = 42,
        SECOND = 'some_value';
}
