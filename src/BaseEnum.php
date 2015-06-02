<?php

namespace Greg0ire\Enum;

abstract class BaseEnum
{
    private static $constCache = array();

    /**
     * Uses reflection to find the constants defined in the class and cache
     * them in a local property for performance, before returning them.
     *
     * @return array a hash with your constants and their value. Useful for
     *               building a choice widget
     */
    public static function getConstants()
    {
        $enumTypes = static::getEnumTypes();
        $enums     = array();

        if (!is_array($enumTypes)) {
            $enumTypes = array($enumTypes);
        }
        foreach ($enumTypes as $key => $enumType) {
            $cacheKey = is_integer($key) ? $enumType : $key;

            if (!isset(self::$constCache[$cacheKey])) {
                $reflect                     = new \ReflectionClass($enumType);
                self::$constCache[$cacheKey] = $reflect->getConstants();
            }
            if (count($enumTypes) > 1) {
                foreach (self::$constCache[$cacheKey] as $subKey => $value) {
                    $subKey         = $cacheKey . (is_integer($key) ? '::' : '.') . $subKey;
                    $enums[$subKey] = $value;
                }
            } else {
                $enums = self::$constCache[$cacheKey];
            }
        }

        return $enums;
    }

    /**
     * Checks whether a constant with this name is defined.
     *
     * @param string  $name   the name of the constant
     * @param boolean $strict whether to make a case sensitive check
     *
     * @return boolean the result of the test
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));

        return in_array(strtolower($name), $keys);
    }

    /**
     * Checks whether a constant with this value is defined.
     *
     * @param int|string $value  the value to test
     * @param bool       $strict check the types of the value in the values
     *
     * @return bool the result of the test
     *
     */
    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict);
    }

    /**
     * Adds possibility several classes together
     *
     * @return array
     */
    protected static function getEnumTypes()
    {
        return array(get_called_class());
    }
}
