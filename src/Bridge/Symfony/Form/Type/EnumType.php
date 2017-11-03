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

        $resolver->setDefault('prefix_label_with_class', false);
        $resolver->setAllowedTypes('prefix_label_with_class', 'bool');

        $resolver->setDefault('choices', function (Options $options) {
            $class = $options['class'];

            $keys = $options['prefix_label_with_class']
                ? call_user_func([$class, 'getClassPrefixedKeys'], 'strtolower')
                : call_user_func([$class, 'getKeys'], 'strtolower');

            return array_combine($keys, call_user_func([$class, 'getConstants']));
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
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}
