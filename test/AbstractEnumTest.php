<?php

namespace Greg0ire\Enum\Tests;

use Greg0ire\Enum\Tests\Fixtures\AllEnum;
use Greg0ire\Enum\Tests\Fixtures\DummyEnum;
use Greg0ire\Enum\Tests\Fixtures\FooEnum;

class AbstractEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testDummyGetConstants()
    {
        $this->assertSame(
            array(
                'FIRST' => 42,
                'SECOND' => 'some_value',
            ),
            DummyEnum::getConstants()
        );
    }

    public function testFooGetConstants()
    {
        $this->assertSame(
            array(
                'GOD' => 'Dieu',
                'CHUCK' => 'Chuck Norris',
                'GUITRY' => 'Sacha Guitry',
            ),
            FooEnum::getConstants()
        );
    }

    public function testAllGetConstants()
    {
        $this->assertSame(
            array(
                'originally.GOD' => 'Dieu',
                'originally.CHUCK' => 'Chuck Norris',
                'originally.GUITRY' => 'Sacha Guitry',
                'Greg0ire\Enum\Tests\Fixtures\DummyEnum::FIRST' => 42,
                'Greg0ire\Enum\Tests\Fixtures\DummyEnum::SECOND' => 'some_value',
            ),
            AllEnum::getConstants()
        );
    }

    public function testFooGetKeys()
    {
        $this->assertSame(
            array(
                'GOD',
                'CHUCK',
                'GUITRY',
            ),
            FooEnum::getKeys()
        );

        $this->assertSame(
            array(
                'god',
                'chuck',
                'guitry',
            ),
            FooEnum::getKeys('strtolower')
        );
    }

    public function testsIsValidName()
    {
        $this->assertFalse(DummyEnum::isValidName('fiRsT'));
        $this->assertFalse(DummyEnum::isValidName('invalid'));
    }

    public function testIsValidValue()
    {
        $this->assertTrue(DummyEnum::isValidValue(42));
        $this->assertFalse(DummyEnum::isValidValue('42'));
    }
}
