Upgrade from 1.0 to 1.1
=======================

### General

 * The method `getEnumTypes` was added to Greg0ire\Enum\BaseEnum.

### Method isValidValue

 * The only difference is the number of arguments.

   | Old                    | New
   | -----------------------| --------------------------------------
   | `isValidValue($value)` | `isValidValue($value, $strict = true)`

`$strict` : if true, the types of the `$value` in the `$values`
