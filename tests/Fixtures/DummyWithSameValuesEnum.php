<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\AbstractEnum;

final class DummyWithSameValuesEnum extends AbstractEnum
{
    const FIRST = 42;
    const SECOND = 42;
}
