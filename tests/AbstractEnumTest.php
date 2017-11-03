<?php

namespace Greg0ire\Enum\Tests;

use Greg0ire\Enum\Exception\InvalidEnumName;
use Greg0ire\Enum\Exception\InvalidEnumValue;
use Greg0ire\Enum\Tests\Fixtures\AllEnum;
use Greg0ire\Enum\Tests\Fixtures\DummyEnum;
use Greg0ire\Enum\Tests\Fixtures\DummyWithSameValuesEnum;
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
            [
                'god' => 'Dieu',
                'chuck' => 'Chuck Norris',
                'guitry' => 'Sacha Guitry',
            ],
            FooEnum::getConstants('strtolower')
        );

        $this->assertSame(
            [
                'greg0ire.enum.tests.fixtures.foo_enum.god' => 'Dieu',
                'greg0ire.enum.tests.fixtures.foo_enum.chuck' => 'Chuck Norris',
                'greg0ire.enum.tests.fixtures.foo_enum.guitry' => 'Sacha Guitry',
            ],
            FooEnum::getConstants('strtolower', true, '.')
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
            [
                'originally.god' => 'Dieu',
                'originally.chuck' => 'Chuck Norris',
                'originally.guitry' => 'Sacha Guitry',
                'greg0ire\enum\tests\fixtures\dummyenum::first' => 42,
                'greg0ire\enum\tests\fixtures\dummyenum::second' => 'some_value',
            ],
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

    public function testFooGetClassPrefixedKeys()
    {
        $this->assertSame(
            [
                'greg0ire_enum_tests_fixtures_foo_enum_GOD',
                'greg0ire_enum_tests_fixtures_foo_enum_CHUCK',
                'greg0ire_enum_tests_fixtures_foo_enum_GUITRY',
            ],
            FooEnum::getClassPrefixedKeys()
        );

        $this->assertSame(
            [
                'greg0ire_enum_tests_fixtures_foo_enum_god',
                'greg0ire_enum_tests_fixtures_foo_enum_chuck',
                'greg0ire_enum_tests_fixtures_foo_enum_guitry',
            ],
            FooEnum::getClassPrefixedKeys('strtolower')
        );

        $this->assertSame(
            [
                'greg0ire.enum.tests.fixtures.foo_enum.god',
                'greg0ire.enum.tests.fixtures.foo_enum.chuck',
                'greg0ire.enum.tests.fixtures.foo_enum.guitry',
            ],
            FooEnum::getClassPrefixedKeys('strtolower', '.')
        );
    }

    public function testsIsValidName()
    {
        $this->assertFalse(DummyEnum::isValidName('fiRsT'));
        $this->assertFalse(DummyEnum::isValidName('invalid'));
    }

    public function testAssertValidName()
    {
        $this->expectException(InvalidEnumName::class);
        $this->expectExceptionMessage(
            '"fiRsT" is not a valid name, valid names are: ("FIRST", "SECOND")'
        );
        DummyEnum::assertValidName('fiRsT');
    }

    public function testIsValidValue()
    {
        $this->assertTrue(DummyEnum::isValidValue(42));
        $this->assertFalse(DummyEnum::isValidValue('42'));
    }

    public function testAssertValidValue()
    {
        $this->expectException(InvalidEnumValue::class);
        $this->expectExceptionMessage(
            '"test" is not a valid value, valid values are: ("42", "some_value")'
        );
        DummyEnum::assertValidValue('test');
    }

    public function testSimpleKeyFromValue()
    {
        $this->assertSame('FIRST', DummyEnum::getKeysFromValue(42));
    }

    public function testMultiKeysFromValue()
    {
        $this->assertSame(['FIRST', 'SECOND'], DummyWithSameValuesEnum::getKeysFromValue(42));
    }
}
