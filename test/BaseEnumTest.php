<?php
namespace Greg0ire\Enum\Tests;

use Greg0ire\Enum\BaseEnum;

final class Dummy
{
    const FIRST = 42,
        SECOND = 'some_value',
        STATE_CREDITING = 'state';
}

interface Model
{
    const STATE_CANCELED = 1,
        STATE_CREDITED = 2,
        STATE_CREDITING = 3,
        STATE_FAILED = 4,
        STATE_NEW = 5;
}

class BaseEnumTest extends \PHPUnit_Framework_TestCase
{
    /** @var BaseEnum */
    protected static $baseEnum;

    public function setUp()
    {
        self::$baseEnum = new BaseEnum();
        self::$baseEnum->addClass(Dummy::class);
        self::$baseEnum->addClass(Model::class);
    }

    public function testGetConstantsWithoutMerge()
    {
        $baseEnum = self::$baseEnum;
        $this->assertEquals(
            array(
                'Greg0ire\Enum\Tests\Dummy' => array(
                    'FIRST'  => 42,
                    'SECOND' => 'some_value',
                    'STATE_CREDITING' => 'state'
                ),
                'Greg0ire\Enum\Tests\Model' => array(
                    'STATE_CANCELED'  => 1,
                    'STATE_CREDITED' => 2,
                    'STATE_CREDITING' => 3,
                    'STATE_FAILED' => 4,
                    'STATE_NEW' => 5,
                )
            ),
            $baseEnum::getConstants()
        );
    }

    public function testGetConstantsWithMerge()
    {
        $baseEnum = self::$baseEnum;
        $this->assertEquals(
            array(
                'FIRST'  => 42,
                'SECOND' => 'some_value',
                'STATE_CREDITING' => 3,
                'STATE_CANCELED'  => 1,
                'STATE_CREDITED' => 2,
                'STATE_FAILED' => 4,
                'STATE_NEW' => 5,
            ),
            $baseEnum::getConstants(true)
        );
    }

    public function testsIsValidName()
    {
        $baseEnum = self::$baseEnum;
        $this->assertTrue($baseEnum::isValidName('sTaTe_NeW'));
        $this->assertFalse($baseEnum::isValidName('sTaTe_NeW', true));
        $this->assertFalse($baseEnum::isValidName('invalid'));
    }

    public function testIsValidValueWithoutMerge()
    {
        $baseEnum = self::$baseEnum;
        $this->assertFalse($baseEnum::isValidValue('42'));
        $this->assertTrue($baseEnum::isValidValue('state'));
    }

    public function testIsValidValueWithMerge()
    {
        $baseEnum = self::$baseEnum;
        $this->assertFalse($baseEnum::isValidValue('state', false, true));
    }
}
