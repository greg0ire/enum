<?php

namespace Greg0ire\Enum\Bridge\Symfony\Form\Type;

use Greg0ire\Enum\AbstractEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class EnumType extends AbstractType
{
    /** @var bool */
    private $classPrefixed;

    public function __construct($classPrefixed = null)
    {
        $this->classPrefixed = !is_null($classPrefixed) ? $classPrefixed : false;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('class');
        $resolver->setAllowedTypes('class', 'string');
        $resolver->setNormalizer('class', function (Options $options, $class) {
            if (!is_a($class, AbstractEnum::class, true)) {
                throw new LogicException('The option "class" must be a class that inherits from '.AbstractEnum::class);
            }

            return $class;
        });

        $resolver->setDefault('prefix_label_with_class', $this->classPrefixed);
        $resolver->setAllowedTypes('prefix_label_with_class', 'bool');

        $resolver->setDefault('choices', function (Options $options) {
            $class = $options['class'];

            $keys = $options['prefix_label_with_class']
                ? call_user_func([$class, 'getClassPrefixedKeys'], 'strtolower')
                : call_user_func([$class, 'getKeys'], 'strtolower');

            $choices = array_combine($keys, call_user_func([$class, 'getConstants']));
            // SF <3.1 BC
            if ($options->offsetExists('choices_as_values') && !$options['choices_as_values']) {
                return array_flip($choices);
            }

            return $choices;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'enum';
    }

    /**
     * SF <2.8 compatibility.
     *
     * {@inheritdoc}
     */
    public function getName()
    {
        $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        // Symfony <2.8 BC
        if (!method_exists(AbstractType::class, 'getBlockPrefix')) {
            return 'choice';
        }

        return ChoiceType::class;
    }
}
