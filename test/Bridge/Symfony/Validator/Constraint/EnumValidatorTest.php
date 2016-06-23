<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\Validator\Constraint;

use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Greg0ire\Enum\Tests\Fixtures\AllEnum;
use Greg0ire\Enum\Tests\Fixtures\DummyEnum;
use Greg0ire\Enum\Tests\Fixtures\FooEnum;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\ChoiceValidator;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class EnumValidatorTest extends AbstractConstraintValidatorTest
{
    public function testNullIsValid()
    {
        $this->validator->validate(null, new Enum(DummyEnum::class));

        $this->assertNoViolation();
    }

    public function testBlankButStringIsInvalid()
    {
        $this->validator->validate(' ', new Enum(DummyEnum::class));

        $this->buildViolation('The value you selected is not a valid choice.')
            ->setParameter('{{ value }}', '" "')
            ->setCode(Choice::NO_SUCH_CHOICE_ERROR)
            ->assertRaised();
    }

    public function testValidValues()
    {
        $this->validator->validate(DummyEnum::FIRST, new Enum(DummyEnum::class));
        $this->validator->validate(DummyEnum::SECOND, new Enum(DummyEnum::class));

        foreach (FooEnum::getConstants() as $value) {
            $this->validator->validate($value, new Enum(FooEnum::class));
        }

        foreach (AllEnum::getConstants() as $value) {
            $this->validator->validate($value, new Enum(AllEnum::class));
        }

        $this->assertNoViolation();
    }

    public function testInvalidValue()
    {
        $this->validator->validate(1337, new Enum(DummyEnum::class));

        $this->buildViolation('The value you selected is not a valid choice.')
            ->setParameter('{{ value }}', '1337')
            ->setCode(Choice::NO_SUCH_CHOICE_ERROR)
            ->assertRaised();
    }

    public function testInvalidValueWithShowKeys()
    {
        $this->validator->validate(1337, new Enum([
            'class' => DummyEnum::class,
            'showKeys' => true,
        ]));

        $this->buildViolation('The value you selected is not a valid choice. '
            .'Valid '.DummyEnum::class.' constant keys are: FIRST, SECOND.')
            ->setParameter('{{ value }}', '1337')
            ->setCode(Choice::NO_SUCH_CHOICE_ERROR)
            ->assertRaised();
    }

    /**
     * {@inheritdoc}
     */
    protected function createValidator()
    {
        return new ChoiceValidator();
    }
}
