<?php

namespace Greg0ire\Enum;

class BaseEnum extends AbstractBaseEnum
{
    private static $classes;

    public function __construct($className = null)
    {
        if ($className) {
            $this->addClass($className);
        }
    }

    /**
     * Add new class|interface name will be used
     * to find the constants defined
     *
     * @param string|array $className the name of the class or interface
     */
    public function addClass($className)
    {
        if (is_array($className)) {
            foreach ($className as $class) {
                self::$classes[] = $class;
            }
        } else {
            self::$classes[] = $className;
        }
    }

    /**
     * Uses AbstractBaseEnum::getConstants to find the constants defined
     * and add it in global array, before returning it
     *
     * @param bool $merge Merge all arrays together
     *                    the later value for that key will
     *                    overwrite the previous one
     *
     * @return array a hash with your constants and their value. Useful for
     *               building a choice widget
     *
     * @see parent_method
     */
    public static function getConstants($merge = false)
    {
        $constants = [];

        foreach (self::$classes as $class) {
            if ($merge) {
                $constants = array_merge($constants, parent::getConstants($class));
            } else {
                $constants[$class] = parent::getConstants($class);
            }
        }

        return $constants;
    }

    /**
     * @see parent_method
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants(true);

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
     * @param bool          $merge  Merge arrays
     *
     * @return bool the result of the test
     *
     */
    public static function isValidValue($value, $strict = true, $merge = false)
    {
        $values = array_values(self::getConstants($merge));

        return $merge ? in_array($value, $values, $strict) : self::in_array_r($value, $values, $strict);
    }

    /**
     * Checks if a value exists in an array recursively
     *
     * @param mixed $needle     The searched value
     * @param array $haystack   The array
     * @param bool  $strict     Check the types of the needle in the haystack
     *
     * @return bool
     */
    private static function in_array_r($needle, array $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle)
                || (is_array($item) && self::in_array_r($needle, $item, $strict))
            ) {
                return true;
            }
        }

        return false;
    }
}
