<?php

namespace Greg0ire\Enum;

@trigger_error(
    'The '.__NAMESPACE__.'\BaseEnum class is deprecated since 2.1 and will be removed in 3.0. Use '
    .__NAMESPACE__.'\AbstractEnum instead',
    E_USER_DEPRECATED
);

/**
 * @deprecated since 2.1, will be removed in 3.0.
 */
abstract class BaseEnum extends AbstractEnum
{
}
