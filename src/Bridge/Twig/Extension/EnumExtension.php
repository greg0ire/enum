<?php

namespace Greg0ire\Enum\Bridge\Twig\Extension;

use Greg0ire\Enum\AbstractEnum;
use Greg0ire\Enum\Bridge\Symfony\Translator\GetLabel;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class EnumExtension extends AbstractExtension
{
    /**
     * @var GetLabel
     */
    private $label;

    public function __construct($label)
    {
        if ($label instanceof TranslatorInterface) {
            @trigger_error(sprintf(
                'Providing a %s instance to %s is deprecated and will not be supported in 5.0. Please provide a %s instance instead.',
                TranslatorInterface::class,
                __METHOD__,
                GetLabel::class
            ), E_USER_DEPRECATED);
            $this->label = new GetLabel($label);
            
            return;
        }
        
        $this->label = $label;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [new TwigFilter('enum_label', [$this, 'label'])];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('enum_get_constants', [$this, 'getConstants']),
            new TwigFunction('enum_get_keys', [$this, 'getKeys']),
            new TwigFunction('enum_get_class_prefixed_keys', [$this, 'getClassPrefixedKeys']),
        ];
    }

    /**
     * Displays the label corresponding to a specific value of an enumeration.
     *
     * @param mixed       $value              Must exists in the enumeration class specified with $class
     * @param string      $class              The enum class name
     * @param string|bool $translationDomain  the translation domain to use if the translator if available.
     *                                        string: Use the specified one
     *                                        null: Use the default one
     *                                        false: Do not use the translator
     * @param bool        $classPrefixed      Prefix the label with the enum class. Defaults to true if the translator
     *                                        is available and enabled, false otherwise.
     * @param string      $namespaceSeparator namespace separator to use with the class prefix.
     *                                        This takes effect only if $classPrefixed is true
     */
    public function label(
        $value,
        string $class,
        $translationDomain = null,
        ?bool $classPrefixed = null,
        ?string $namespaceSeparator = null
    ): string {
        return ($this->label)($value, $class, $translationDomain, $classPrefixed, $namespaceSeparator);
    }

    /**
     * @see AbstractEnum::getConstants()
     */
    public function getConstants(
        string $class,
        ?callable $keysCallback = null,
        ?bool $classPrefixed = false,
        ?string $namespaceSeparator = null
    ): array {
        return call_user_func([$class, 'getConstants'], $keysCallback, $classPrefixed, $namespaceSeparator);
    }

    /**
     * @see AbstractEnum::getKeys()
     */
    public function getKeys(string $class, ?callable $callback = null)
    {
        return call_user_func([$class, 'getKeys'], $callback);
    }

    /**
     * @see AbstractEnum::getClassPrefixedKeys()
     */
    public function getClassPrefixedKeys(
        string $class,
        ?callable $callback = null,
        ?string $namespaceSeparator = null
    ): array {
        return call_user_func([$class, 'getClassPrefixedKeys'], $callback, $namespaceSeparator);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'greg0ire_enum';
    }
}
