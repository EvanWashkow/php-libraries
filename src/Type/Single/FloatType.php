<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Single;

use EvanWashkow\PhpLibraries\Type\Type;

/**
 * Defines a floating point number type
 */
class FloatType extends Type
{
    /** @var string The type name for a double */
    public const DOUBLE_NAME = 'double';

    /** @var string The type name for a float */
    public const FLOAT_NAME = 'float';

    public function __construct()
    {
        parent::__construct(self::FLOAT_NAME);
    }

    final public function isValueOfType($value): bool
    {
        return is_float($value);
    }

    final protected function isOfType(Type $type): bool
    {
        return $type instanceof self;
    }

    final protected function isOfTypeName(string $typeName): bool
    {
        return in_array($typeName, [self::FLOAT_NAME, self::DOUBLE_NAME], true);
    }
}
