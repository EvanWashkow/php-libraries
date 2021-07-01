<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Single;

use EvanWashkow\PhpLibraries\Type\Type;

/**
 * Defines a boolean type
 */
class BooleanType extends Type
{
    /** @var string The full type name */
    public const BOOLEAN_NAME = 'boolean';

    /** @var string A common alias for the type name */
    public const BOOL_NAME = 'bool';

    public function __construct()
    {
        parent::__construct(self::BOOLEAN_NAME);
    }

    final public function isValueOfType($value): bool
    {
        return is_bool($value);
    }

    final protected function isOfType(Type $type): bool
    {
        return $type instanceof self;
    }

    final protected function isOfTypeName(string $typeName): bool
    {
        return in_array($typeName, [$this->getName(), 'bool'], true);
    }
}
