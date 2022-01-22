<?php

declare(strict_types=1);

namespace PHP\Types;

use PHP\Enums\StringEnum;

/**
 * Defines list of known type names
 */
final class TypeNames extends StringEnum
{
    /** @var string ARRAY The array type name */
    public const ARRAY = 'array';

    /** @var string BOOL The boolean type name */
    public const BOOL = 'bool';

    /** @var string BOOLEAN The (longer) boolean type name */
    public const BOOLEAN = 'boolean';

    /** @var string DOUBLE Alternate name for a float */
    public const DOUBLE = 'double';

    /** @var string FLOAT The float type name */
    public const FLOAT = 'float';

    /** @var string FUNCTION The function type name */
    public const FUNCTION = 'function';

    /** @var string INT The integer type name */
    public const INT = 'int';

    /** @var string INTEGER The (longer) integer type name */
    public const INTEGER = 'integer';

    /** @var string NULL The null type name (http://php.net/manual/en/language.types.null.php) */
    public const NULL = 'null';

    /** @var string STRING The string type name */
    public const STRING = 'string';
}
