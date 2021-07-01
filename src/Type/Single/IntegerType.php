<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Single;

/**
 * Defines an integer type
 */
class IntegerType extends Type
{
    /** @var string The longer type name */
    public const INTEGER_NAME = 'integer';

    /** @var string The shorter type name */
    public const INT_NAME = 'int';

    public function __construct()
    {
        parent::__construct(self::INTEGER_NAME);
    }

    final public function isValueOfType($value): bool
    {
        return is_int($value);
    }

    final protected function isOfType(Type $type): bool
    {
        return $type instanceof self;
    }

    final protected function isOfTypeName(string $typeName): bool
    {
        return in_array($typeName, [self::INTEGER_NAME, self::INT_NAME], true);
    }
}
