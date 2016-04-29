<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\Validator\Constraint;

use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Greg0ire\Enum\Tests\Fixtures\AllEnum;
use Greg0ire\Enum\Tests\Fixtures\DummyEnum;
use Greg0ire\Enum\Tests\Fixtures\FooEnum;
use Greg0ire\Enum\Tests\Fixtures\FooInterface;

final class EnumTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getValidEnums
     */
    public function testValidEnumClasses($enumClass)
    {
        $enumConstraint = new Enum($enumClass);

        $this->assertSame($enumClass, $enumConstraint->class);
    }

    public function getValidEnums()
    {
        return array(
            array(AllEnum::class),
            array(DummyEnum::class),
            array(FooEnum::class),
        );
    }

    /**
     * @dataProvider getInvalidEnums
     */
    public function testInvalidEnumClasses($enumClass)
    {
        $this->setExpectedException('\Symfony\Component\Validator\Exception\ConstraintDefinitionException');

        new Enum($enumClass);
    }

    public function getInvalidEnums()
    {
        return array(
            array(FooInterface::class),
            array(\StdClass::class),
            array('This\Does\Not\Exist\At\All'),
        );
    }
}
