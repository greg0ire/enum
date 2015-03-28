CHANGELOG for 2.0.x
===================

This changelog references the relevant changes done in 2.0 minor versions.

### Method isValidValue

 * The only difference is that number of arguments are differents.

   | Old | New
   | -------- | ---
   | `isValidValue($value)` | `isValidValue($value, $strict = true)`

The `$strict` variable check the types of the needle in the values