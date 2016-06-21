<?php

namespace Greg0ire\Enum;

use Doctrine\Common\Inflector\Inflector;

/**
 * @author Grégoire Paris <postmaster@greg0ire.fr>
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractEnum
{
    /**
     * @var string
     */
    public static $defaultNamespaceSeparator = '_';

    private static $constCache = [];

    /**
     * Uses reflection to find the constants defined in the class and cache
     * them in a local property for performance, before returning them.
     *
     * @param callable|null $keysCallback
     * @param bool          $classPrefixed      True if you want the enum class prefix on each keys, false otherwise.
     * @param string        $namespaceSeparator Only relevant if $classPrefixed is set to true.
     *
     * @return array a hash with your constants and their value. Useful for
     *               building a choice widget
     */
    final public static function getConstants($keysCallback = null, $classPrefixed = false, $namespaceSeparator = null)
    {
        $namespaceSeparator = $namespaceSeparator ?: static::$defaultNamespaceSeparator;
        $enumTypes = static::getEnumTypes();
        $enums = [];

        if (!is_array($enumTypes)) {
            $enumTypes = [$enumTypes];
        }
        foreach ($enumTypes as $key => $enumType) {
            $cacheKey = is_int($key) ? $enumType : $key;

            if (!isset(self::$constCache[$cacheKey])) {
                $reflect = new \ReflectionClass($enumType);
                self::$constCache[$cacheKey] = $reflect->getConstants();
            }
            if (count($enumTypes) > 1) {
                foreach (self::$constCache[$cacheKey] as $subKey => $value) {
                    $subKey = $cacheKey.(is_int($key) ? '::' : '.').$subKey;
                    $enums[$subKey] = $value;
                }
            } else {
                $enums = self::$constCache[$cacheKey];
            }
        }

        if (is_callable($keysCallback) || $classPrefixed) {
            return array_combine(
                $classPrefixed
                    ? static::getClassPrefixedKeys($keysCallback, $namespaceSeparator)
                    : static::getKeys($keysCallback),
                $enums
            );
        }

        return $enums;
    }

    /**
     * Returns constants keys.
     *
     * @param callable|null $callback A callable function compatible with array_map
     *
     * @return string[]
     */
    final public static function getKeys($callback = null)
    {
        $keys = array_keys(static::getConstants());

        if (null !== $callback) {
            return array_map($callback, $keys);
        }

        return $keys;
    }

    /**
     * @param callable|null $callback           A callable function compatible with array_map
     * @param string|null   $namespaceSeparator Choose which character should replace namespaces separation.
     *                                          Example: With Foo\BarMagic enum class with '.' separator,
     *                                          it will be converted to foo.bar_magic.YOUR_KEY
     *
     * @return string[]
     */
    final public static function getClassPrefixedKeys($callback = null, $namespaceSeparator = null)
    {
        $namespaceSeparator = $namespaceSeparator ?: static::$defaultNamespaceSeparator;
        $classKey = str_replace('\\', $namespaceSeparator, Inflector::tableize(static::class));

        $keys = static::getKeys(function ($key) use ($namespaceSeparator, $classKey) {
            return $classKey.$namespaceSeparator.$key;
        });

        if (is_callable($callback)) {
            return array_map($callback, $keys);
        }

        return $keys;
    }

    /**
     * Checks whether a constant with this name is defined.
     *
     * @param string $name the name of the constant
     *
     * @return bool the result of the test
     */
    final public static function isValidName($name)
    {
        return array_key_exists($name, self::getConstants());
    }

    /**
     * Checks whether a constant with this value is defined.
     *
     * @param int|string $value  the value to test
     * @param bool       $strict check the types of the value in the values
     *
     * @return bool the result of the test
     */
    final public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict);
    }

    /**
     * Adds possibility several classes together.
     *
     * @return array
     */
    protected static function getEnumTypes()
    {
        return [get_called_class()];
    }
}
