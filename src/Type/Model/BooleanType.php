<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Model;

/**
 * Defines a boolean type
 */
class BooleanType extends Type
{
    public function __construct()
    {
        parent::__construct('boolean');
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
