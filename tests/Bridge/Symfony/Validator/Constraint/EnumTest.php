<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\Validator\Constraint;

use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Greg0ire\Enum\Tests\Fixtures\AllEnum;
use Greg0ire\Enum\Tests\Fixtures\DummyEnum;
use Greg0ire\Enum\Tests\Fixtures\FooEnum;
use Greg0ire\Enum\Tests\Fixtures\FooInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

final class EnumTest extends TestCase
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
        return [
            [AllEnum::class],
            [DummyEnum::class],
            [FooEnum::class],
        ];
    }

    /**
     * @dataProvider getInvalidEnums
     */
    public function testInvalidEnumClasses($enumClass)
    {
        $this->expectException(ConstraintDefinitionException::class);

        new Enum($enumClass);
    }

    public function getInvalidEnums()
    {
        return [
            [FooInterface::class],
            [\StdClass::class],
            ['This\Does\Not\Exist\At\All'],
        ];
    }
}
