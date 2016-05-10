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
            [
                'FIRST' => 42,
                'SECOND' => 'some_value',
            ],
            DummyEnum::getConstants()
        );
    }

    public function testFooGetConstants()
    {
        $this->assertSame(
            [
                'GOD' => 'Dieu',
                'CHUCK' => 'Chuck Norris',
                'GUITRY' => 'Sacha Guitry',
            ],
            FooEnum::getConstants()
        );

        $this->assertSame(
            array(
                'god' => 'Dieu',
                'chuck' => 'Chuck Norris',
                'guitry' => 'Sacha Guitry',
            ),
            FooEnum::getConstants('strtolower')
        );
    }

    public function testAllGetConstants()
    {
        $this->assertSame(
            [
                'originally.GOD' => 'Dieu',
                'originally.CHUCK' => 'Chuck Norris',
                'originally.GUITRY' => 'Sacha Guitry',
                'Greg0ire\Enum\Tests\Fixtures\DummyEnum::FIRST' => 42,
                'Greg0ire\Enum\Tests\Fixtures\DummyEnum::SECOND' => 'some_value',
            ],
            AllEnum::getConstants()
        );

        $this->assertSame(
            array(
                'originally.god' => 'Dieu',
                'originally.chuck' => 'Chuck Norris',
                'originally.guitry' => 'Sacha Guitry',
                'greg0ire\enum\tests\fixtures\dummyenum::first' => 42,
                'greg0ire\enum\tests\fixtures\dummyenum::second' => 'some_value',
            ),
            AllEnum::getConstants('strtolower')
        );
    }

    public function testFooGetKeys()
    {
        $this->assertSame(
            [
                'GOD',
                'CHUCK',
                'GUITRY',
            ],
            FooEnum::getKeys()
        );

        $this->assertSame(
            [
                'god',
                'chuck',
                'guitry',
            ],
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
