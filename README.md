# Enums

This package holds a simple class that may be used as an ancestor for your
enum classes.

[![Build Status][3]](https://travis-ci.org/greg0ire/enum)

## Installation

    composer require greg0ire/enum

## Usage

#### via AbstractBaseEnum

Extend the `Greg0ire\Enum\AbstractBaseEnum`, define your enum key values as constants,
and Bob's your uncle. You can make the class abstract or final, as you see fit.

```php
use Greg0ire\Enum\AbstractBaseEnum;

final class DaysOfWeek extends AbstractBaseEnum {
    const Sunday = 0;
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;
}
```

Then, you may use the DaysOfWeek class for input validation:

```php
DaysOfWeek::isValidName('Humpday');                  // false
DaysOfWeek::isValidName('Monday');                   // true
DaysOfWeek::isValidName('monday');                   // true
DaysOfWeek::isValidName('monday', $strict = true);   // false
DaysOfWeek::isValidName(0);                          // false

DaysOfWeek::isValidValue(0);                         // true
DaysOfWeek::isValidValue(5);                         // true
DaysOfWeek::isValidValue(7);                         // false
DaysOfWeek::isValidValue('Friday');                  // false
```

Additionally, you may get all the constants in your class as a hash:

```php
DaysOfWeek::getConstants()
```

#### via BaseEnum

Instantiate a variable with BaseEnum.
Now just add in this variable the strings of class or interface name.
You could use all methods of AbstractBaseEnum.

```php
interface CreditInterface
{
    const STATE_CANCELED = 1;
    const STATE_CREDITED = 2;
    const STATE_CREDITING = 3;
    const STATE_FAILED = 4;
    const STATE_NEW = 5;
}

interface FinancialTransactionInterface
{
    const STATE_CANCELED = 1;
    const STATE_FAILED = 2;
    const STATE_NEW = 3;
    const STATE_PENDING = 4;
    const STATE_SUCCESS = 5;
    const TRANSACTION_TYPE_APPROVE = 1;
    const TRANSACTION_TYPE_APPROVE_AND_DEPOSIT = 2;
    const TRANSACTION_TYPE_CREDIT = 3;
    const TRANSACTION_TYPE_DEPOSIT = 4;
    const TRANSACTION_TYPE_REVERSE_APPROVAL = 5;
    const TRANSACTION_TYPE_REVERSE_CREDIT = 6;
    const TRANSACTION_TYPE_REVERSE_DEPOSIT = 7;
}
```

```php
use Greg0ire\Enum\BaseEnum;

$baseEnum = new BaseEnum();

$baseEnum->addClass(CreditInterface::class);
$baseEnum->addClass(FinancialTransactionInterface::class);
// OR
$baseEnum->addClass([CreditInterface::class, FinancialTransactionInterface::class]);

$baseEnum::getConstants();
```

However a small specificity with the method `isValidValue()`.
You could pass a third argument for merging arrays.
Don't forget the later value for the same key will overwrite the previous one

## Contributing

see [CONTRIBUTING.md][1]

## Credits

This is a shameless rip-off of [this Stack Overflow answer][0], with one
modification: the `getConstants` method has been made public so that it is
available for building choice widgets, for instance. If you want to give credit
to someone for this, give it to [Brian Cline][2]

[0]: http://stackoverflow.com/a/254543/353612
[1]: ./CONTRIBUTING.md
[2]: http://stackoverflow.com/users/32536/brian-cline
[3]: https://travis-ci.org/greg0ire/enum.svg?branch=master
