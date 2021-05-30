<?php
declare(strict_types = 1);

namespace EvanWashkow\PhpLibraries\Type\Model;

/**
 * Defines a floating point number type
 */
class FloatType extends Type
{
    public function __construct()
    {
        parent::__construct('float');
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
        return in_array($typeName, [$this->getName(), 'double'], true);
    }
}
