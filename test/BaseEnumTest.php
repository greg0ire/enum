<?php
namespace Greg0ire\Enum\Tests;

use Greg0ire\Enum\BaseEnum;

final class DummyEnum extends BaseEnum
{
    const FIRST = 42,
        SECOND = 'some_value';
}

class BaseEnumTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConstants()
    {
        $this->assertEquals(
            array(
                'FIRST'  => 42,
                'SECOND' => 'some_value'
            ),
            DummyEnum::getConstants()
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
