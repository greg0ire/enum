# Enums

This package holds a simple class that may be used as an ancestor for your
enum classes.

[![Build Status][3]](https://travis-ci.org/greg0ire/enum)

## Installation

    composer require greg0ire/enum

## Usage

### Basic usage

Extend the `Greg0ire\Enum\AbstractEnum`, define your enum key values as constants,
and Bob's your uncle. You can make the class abstract or final, as you see fit.

```php
use Greg0ire\Enum\AbstractEnum;

final class DaysOfWeek extends AbstractEnum {
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
DaysOfWeek::isValidName('monday');                   // false
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

You may also get all the keys in your class as an array:

```php
DaysOfWeek::getKeys();
DaysOfWeek::getKeys('strtolower'); // Will call `array_map` with the given callback.
```

### Advanced usage

If you need to get the constants from a class you cannot modify, or from an
interface, or even from several classes / interfaces, you may override
`AbstractEnum::getEnumTypes()`.

For example, if you have the following class and interface :


```php
namespace Vendor\Namespace;

class ClassFromAVendor
{
   const SOMETHING      = 'something';
   const SOMETHING_ELSE = 'something_else';
}
```

```php
namespace My\Namespace;

interface SomeInterface
{
   const ANOTHER_CONST = 'another_const';
}
```

You can get all three constants by creating this Enum :

```php
use Greg0ire\Enum\AbstractEnum;

final class MyEnum extends AbstractEnum
{
    protected static function getEnumTypes()
    {
        return array(
            'Vendor\Namespace\ClassFromAVendor',
            'My\Namespace\SomeInterface',
        );
    }
}
```

Alternatively, you can specify a prefix for each type to avoid getting FQCNs in
the hash keys.

```php
use Greg0ire\Enum\AbstractEnum;

final class MyEnum extends AbstractEnum
{
    protected static function getEnumTypes()
    {
        return array(
            'prefix1' => 'Vendor\Namespace\ClassFromAVendor',
            'prefix2' => 'My\Namespace\SomeInterface',
        );
    }
}
```

### Symfony validator

This package provides a "ready to use" symfony validator.
You have to require the `symfony/validator` package to get it working.

```php
use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Symfony\Component\Validator\Validation;
use Your\Namespace\EnumClass;

$validator = Validation::createValidator();

$violations = $validator->validateValue(42, new Enum(EnumClass::class));
// You can also show the constants keys on the error message:
$violations = $validator->validateValue(42, new Enum(['class' => EnumClass::class, 'showKeys' => true]));
```

Another example with annotations:

```php
use Doctrine\Common\Annotations\AnnotationRegistry;
use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Symfony\Component\Validator\Validation;

class MyClass
{
    /**
     * @EnumClass("Your\Namespace\EnumClass")
     */
    private $dummy;

    public function __construct($dummy)
    {
        $this->dummy = $dummy
    }
}

AnnotationRegistry::registerLoader('class_exists');
$validator = Validation::createValidatorBuilder()
    ->enableAnnotationMapping()
    ->getValidator();

$object = new MyClass(42);

$violations = $validator->validate($object);
```

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
