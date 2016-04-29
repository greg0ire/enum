<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\Form\Type;

use Greg0ire\Enum\Bridge\Symfony\Form\Type\EnumType;
use Greg0ire\Enum\Tests\Fixtures\DummyEnum;
use Greg0ire\Enum\Tests\Fixtures\FooInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class EnumTypeTest extends TypeTestCase
{
    public function testEnumChoices()
    {
        $view = $this->factory->create($this->getEnumType(), null, array(
            'class' => DummyEnum::class,
        ))->createView();

        $this->assertSame('42', $view->vars['choices'][0]->value);
        $this->assertSame('some_value', $view->vars['choices'][1]->value);
        $this->assertFalse($view->vars['is_selected']($view->vars['choices'][0], $view->vars['value']));
        $this->assertFalse($view->vars['is_selected']($view->vars['choices'][1], $view->vars['value']));
        $this->assertSame('first', $view->vars['choices'][0]->label);
        $this->assertSame('second', $view->vars['choices'][1]->label);
    }

    public function testEnumChoicesClassPrefix()
    {
        $view = $this->factory->create($this->getEnumType(), null, array(
            'class' => DummyEnum::class,
            'prefix_label_with_class' => true,
        ))->createView();

        $this->assertSame('greg0ire_enum_tests_fixtures_dummy_enum_first', $view->vars['choices'][0]->label);
        $this->assertSame('greg0ire_enum_tests_fixtures_dummy_enum_second', $view->vars['choices'][1]->label);
    }

    /**
     * @dataProvider getInvalidEnums
     *
     * @param string $class
     */
    public function testInvalidEnums($class)
    {
        $this->setExpectedException(
            LogicException::class,
            'The option "class" must be a class that inherits from Greg0ire\Enum\AbstractEnum'
        );

        $this->factory->create($this->getEnumType(), null, array(
            'class' => $class,
        ));

        $this->builder->getForm();
    }

    public function getInvalidEnums()
    {
        return array(
            array(FooInterface::class),
            array(\StdClass::class),
            array('This\Does\Not\Exist\At\All'),
        );
    }

    private function getEnumType()
    {
        // Symfony <2.8 BC
        if (!method_exists(AbstractType::class, 'getBlockPrefix')) {
            return new EnumType();
        }

        return EnumType::class;
    }
}
