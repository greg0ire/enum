<?php

namespace Greg0ire\Enum\Bridge\Symfony\Validator\Constraint;

use Greg0ire\Enum\AbstractEnum;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\ChoiceValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Enum extends Choice
{
    /**
     * @var string
     */
    public $class;

    /**
     * @var bool
     */
    public $showKeys = false;

    /**
     * {@inheritdoc}
     */
    public function __construct($options = null)
    {
        parent::__construct($options);

        if (!is_a($this->class, AbstractEnum::class, true)) {
            throw new ConstraintDefinitionException(
                'The option "class" must be a class that inherits from '.AbstractEnum::class
            );
        }
        $this->choices = call_user_func([$this->class, 'getConstants']);

        if ($this->showKeys) {
            $keysMessage = 'Valid '.$this->class.' constant keys are: {{ choices }}';
            $this->message .= ' '.$keysMessage;
            $this->multipleMessage .= ' '.$keysMessage;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy(): string
    {
        return ChoiceValidator::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption(): string
    {
        return 'class';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions(): array
    {
        return ['class'];
    }
}
