<?php

declare(strict_types=1);

namespace PHP\Enums\Exceptions;

/**
 * Exception thrown when an Enum child class defines constants prohibited by the parent Enum type.
 *
 * For example, when a String Enum attemps to define Integer constants.
 */
class MalformedEnumException extends \LogicException
{
}
