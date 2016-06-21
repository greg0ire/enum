<?php

namespace Greg0ire\Enum\Bridge\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class EnumExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('enum_label', [$this, 'label']),
        ];
    }

    /**
     * Displays the label corresponding to a specific value of an enumeration.
     *
     * @param mixed       $value              Must exists in the enumeration class specified with $class
     * @param string      $class              The enum class name
     * @param string|bool $translationDomain  The translation domain to use if the translator if available.
     *                                        string: Use the specified one
     *                                        null: Use the default one
     *                                        false: Do not use the translator
     * @param bool        $classPrefixed      Prefix the label with the enum class. Defaults to true if the translator
     *                                        is available and enabled, false otherwise.
     * @param string      $namespaceSeparator Namespace separator to use with the class prefix.
     *                                        This takes effect only if $classPrefixed is true.
     *
     * @return string
     */
    public function label($value, $class, $translationDomain = null, $classPrefixed = null, $namespaceSeparator = null)
    {
        // Determine if the translator can be used or not.
        $useTranslation = $this->translator instanceof TranslatorInterface
            && (is_null($translationDomain) || is_string($translationDomain));

        // If not defined, guess the default behavior.
        if (is_null($classPrefixed)) {
            $classPrefixed = $useTranslation;
        }

        $label = array_search(
            $value,
            call_user_func([$class, 'getConstants'], 'strtolower', $classPrefixed, $namespaceSeparator)
        );

        if ($useTranslation) {
            $translatedLabel = $this->translator->trans($label, [], $translationDomain);

            return $translatedLabel ?: $label;
        }

        return $label;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'greg0ire_enum';
    }
}
