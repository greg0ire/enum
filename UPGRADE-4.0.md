# Upgrade from 3.x to 4.0

## Dependencies

Support for Symfony < 3.2 has been dropped.
Support for Twig < 2.0 has been dropped.
Support for PHP < 7.1 has been dropped.

## API

Type hinting has been added to most classes.

### `Greg0ire\Enum\AbstractEnum`

`getEnumTypes` may no longer return a string, it should always return an array
now.
