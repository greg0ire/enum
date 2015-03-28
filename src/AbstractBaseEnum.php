<?php

namespace Greg0ire\Enum;

abstract class AbstractBaseEnum
{
    private static $constCache = array();

    /**
     * Uses reflection to find the constants defined in the class and cache
     * them in a local property for performance, before returning them.
     *
     * @param null $className the name of the class or interface
     *
     * @return array a hash with your constants and their value. Useful for
     *               building a choice widget
     */
    public static function getConstants($className = null)
    {
        if ($className) {
            try {
                if (!class_exists($className) && !interface_exists($className)) {
                    throw new \Exception('The class or interface "' . $className . '" has not been defined');
                }
                $cacheKey = $className;
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $cacheKey = get_called_class();
        }

        if (!isset(self::$constCache[$cacheKey])) {
            $reflect                     = new \ReflectionClass($cacheKey);
            self::$constCache[$cacheKey] = $reflect->getConstants();
        }

        return self::$constCache[$cacheKey];
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
     * @param int|string    $value  the value to test
     * @param bool          $strict check the types of the
     *                              needle in the values
     *
     * @return bool the result of the test
     *
     */
    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict);
    }
}
