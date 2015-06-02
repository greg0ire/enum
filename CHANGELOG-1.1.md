CHANGELOG for 1.1.x
===================

This changelog references the relevant changes done in 1.1 minor versions.

## 1.1.0 (2015-06-02)

### General

 * The method `getEnumTypes` was added to Greg0ire\Enum\BaseEnum.

### Method isValidValue

 * The only difference is the number of arguments.

   | Old                    | New
   | -----------------------| --------------------------------------
   | `isValidValue($value)` | `isValidValue($value, $strict = true)`

`$strict` : if true, the types of the `$value` in the `$values`
