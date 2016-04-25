<?php
namespace Greg0ire\Enum\Tests;

use Greg0ire\Enum\BaseEnum;

final class DummyEnum extends BaseEnum
{
    const FIRST = 42,
        SECOND = 'some_value';
}

interface FooInterface
{
    const GOD = 'Dieu',
        CHUCK = 'Chuck Norris',
        GUITRY = 'Sacha Guitry';
}

final class FooEnum extends BaseEnum
{
    protected static function getEnumTypes()
    {
        return array('Greg0ire\Enum\Tests\FooInterface');
    }
}

final class AllEnum extends BaseEnum
{
    protected static function getEnumTypes()
    {
        return array(
            'originally' => 'Greg0ire\Enum\Tests\FooInterface',
            'Greg0ire\Enum\Tests\DummyEnum',
        );
    }
}

class BaseEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testDummyGetConstants()
    {
        $this->assertEquals(
            array(
                'FIRST'  => 42,
                'SECOND' => 'some_value'
            ),
            DummyEnum::getConstants()
        );
    }

    public function testFooGetConstants()
    {
        $this->assertEquals(
            array(
                'GOD'    => 'Dieu',
                'CHUCK'  => 'Chuck Norris',
                'GUITRY' => 'Sacha Guitry'
            ),
            FooEnum::getConstants()
        );
    }

    public function testAllGetConstants()
    {
        $this->assertEquals(
            array(
                'originally.GOD'                        => 'Dieu',
                'originally.CHUCK'                      => 'Chuck Norris',
                'originally.GUITRY'                     => 'Sacha Guitry',
                'Greg0ire\Enum\Tests\DummyEnum::FIRST'  => 42,
                'Greg0ire\Enum\Tests\DummyEnum::SECOND' => 'some_value'
            ),
            AllEnum::getConstants()
        );
    }

    public function testFooGetKeys()
    {
        $this->assertEquals(
            array(
                'GOD',
                'CHUCK',
                'GUITRY'
            ),
            FooEnum::getKeys()
        );

        $this->assertEquals(
            array(
                'god',
                'chuck',
                'guitry'
            ),
            FooEnum::getKeys('strtolower')
        );
    }

    public function testsIsValidName()
    {
        $this->assertTrue(DummyEnum::isValidName('fiRsT'));
        $this->assertFalse(DummyEnum::isValidName('fiRsT', true));
        $this->assertFalse(DummyEnum::isValidName('invalid'));
    }

    public function testIsValidValue()
    {
        $this->assertTrue(DummyEnum::isValidValue(42));
        $this->assertFalse(DummyEnum::isValidValue('42'));
    }
}
