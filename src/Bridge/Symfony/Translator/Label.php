<?php

namespace Greg0ire\Enum\Bridge\Symfony\Translator;

use Symfony\Contracts\Translation\TranslatorInterface;

final class Label
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Label constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
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
    public function run(
        $value,
        string $class,
        $translationDomain = null,
        ?bool $classPrefixed = null,
        ?string $namespaceSeparator = null
    ): string {
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
}
