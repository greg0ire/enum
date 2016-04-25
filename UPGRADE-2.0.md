Upgrade from 1.x to 2.0
=======================

### BaseEnum class update

* `getConstants`, `isValidName` and `isValidValue` methods are now final.
* The `Greg0ire\Enum\BaseEnum::isValidName` method does not have a `$strict` argument anymore.
All verifications will be strict now.
