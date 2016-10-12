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
DaysOfWeek::getConstants();
DaysOfWeek::getConstants('strtolower'); // Will combine your values with `DaysOfWeek::getKeys($callback)`.
DaysOfWeek::getConstants('strtolower', true); // Values combine with `DaysOfWeek::getClassPrefixedKeys($callback)`.
DaysOfWeek::getConstants('strtolower', true, '.'); // Same with `DaysOfWeek::getClassPrefixedKeys($callback, $separator)`.
```

You may also get all the keys in your class as an array:

```php
DaysOfWeek::getKeys();
DaysOfWeek::getKeys('strtolower'); // Will call `array_map` with the given callback.
```

Or the key with the enum class prefix:

```php
DaysOfWeek::getClassPrefixedKeys();
DaysOfWeek::getClassPrefixedKeys('strtolower'); // Will call `array_map` with the given callback.
DaysOfWeek::getClassPrefixedKeys('strtolower', '.'); // Replace the namespace separator ('_' by default).
```

If you would like to get the keys from a value:

```php
$key = DaysOfWeek::getKeysFromValue(1); // Monday will be assigned to $key
```

If you have many keys with the same value you will get an array, and a value otherwise.

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

### Integration with other libraries

`greg0ire/enum` integrates with other libraries. The list is available in the
`suggest` section of the Composer dependency manifest.

#### Symfony validator

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
// Enum constraint inherits from Choice constraint. You can use inherited options too:
$violations = $validator->validateValue(42, new Enum(['class' => EnumClass::class, 'strict' => true]));
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

Note: You will have to get `doctrine/annotations` and `doctrine/cache` packages to get it working.

#### Symfony form

This package provides a "ready to use" symfony form type.
You have to require the `symfony/form` package to get it working.

```php
use Greg0ire\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Form\Forms;
use Your\Namespace\EnumClass;

$formFactory = Forms::createFormFactory();

$view = $this->factory->create(EnumType::class, null, array(
    'class' => EnumClass::class,
))->createView();
```

#### Twig extension

This package comes with an `enum_label` filter, available thanks to the `EnumExtension` Twig class.
You have to require the `twig/twig` package to get it working.

The filter will try to return the constant label corresponding to the given value.

It will try to translate it if possible. To enable translation, require the `symfony/translation` component
and pass a `Symfony\Component\Translation\TranslationInterface` instance on the `EnumExtension` constructor.

If translation is not available, you will have the default label with class prefixing.

Usage:

```twig
{{ value|enum_label('Your\\Enum\\Class') }}
{{ value|enum_label('Your\\Enum\\Class', 'another_domain') }} {# Change the translation domain #}
{{ value|enum_label('Your\\Enum\\Class', false) }} {# Disable translation. In this case the class prefix wont be added #}
{{ value|enum_label('Your\\Enum\\Class', false, true) }} {# Disable translation but keep class prefix #}
{{ value|enum_label('Your\\Enum\\Class', false, true, '.') }} {# Disable translation but keep class prefix with a custom separator #}
```

##### Twig extension as a service

On Symfony projects, the extension can be autoloaded.
First, you have to require the `symfony/framework-bundle` and `symfony/twig-bundle` packages, or use Symfony fullstack.

Then, register the bundle in the kernel of your application:

``` php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Greg0ire\Enum\Bridge\Symfony\Bundle\Greg0ireEnumBundle(),
    );

    // ...

    return $bundles
}
```

That's all. You can now directly use the filter.

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
