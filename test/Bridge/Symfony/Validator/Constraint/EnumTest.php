<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\Validator\Constraint;

use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;

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
            array('Greg0ire\Enum\Tests\Fixtures\AllEnum'),
            array('Greg0ire\Enum\Tests\Fixtures\DummyEnum'),
            array('Greg0ire\Enum\Tests\Fixtures\FooEnum'),
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
            array('Greg0ire\Enum\Tests\Fixtures\FooInterface'),
            array('\StdClass'),
            array('This\Does\Not\Exist\At\All'),
        );
    }
}
