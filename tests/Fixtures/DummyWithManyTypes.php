<?php

namespace Greg0ire\Enum\Tests\Fixtures;

use Greg0ire\Enum\AbstractEnum;

final class DummyWithManyTypes extends AbstractEnum
{
    const DIGIT = 42;
    const TEXT = '42';
    const BOOLEAN = true;
    const AN_ARRAY = ['foo', 'bar'];
}
