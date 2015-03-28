<?php
namespace Greg0ire\Enum\Tests;

use Greg0ire\Enum\AbstractBaseEnum;

final class DummyEnum extends AbstractBaseEnum
{
    const FIRST = 42,
        SECOND = 'some_value';
}

class AbstractBaseEnumTest extends \PHPUnit_Framework_TestCase
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
