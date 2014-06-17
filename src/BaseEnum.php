<?php

namespace Greg0ire\Enum;

abstract class BaseEnum
{
    private static $constCache = NULL;

    /**
     * Uses reflection to find the constants defined in the class and cache
     * them in a local property for performance, before returning them.
     *
     * @return array a hash with your constants and their value. Useful for
     *               building a choice widget
     */
    public static function getConstants()
    {
        if (self::$constCache === NULL) {
            $reflect = new \ReflectionClass(get_called_class());
            self::$constCache = $reflect->getConstants();
        }

        return self::$constCache;
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
     * @param mixed string|int the value to test
     *
     * @return boolean the result of the test
     */
    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict = true);
    }
}
