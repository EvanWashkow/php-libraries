<?php
namespace PHP\Types;

/**
 * Defines list of known type names
 */
final class TypeNames
{
    /** @var string CALLABLE Base name for any "callable" type (http://php.net/manual/en/language.types.callable.php) */
    const CALLABLE = 'callable';

    /** @var string FUNCTION The function type name */
    const FUNCTION = 'function';

    /** @var string UNKNOWN The unknown type name (http://php.net/manual/en/function.gettype.php) */
    const UNKNOWN = 'unknown type';
}
