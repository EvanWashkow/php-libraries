<?php
declare(strict_types = 1);

namespace PHP\Type\Model;

/**
 * Defines a floating point number type
 */
class FloatType extends Type
{
    public function __construct()
    {
        parent::__construct('float');
    }

    public function isValueOfType($value): bool
    {
        return is_float($value);
    }

    protected function isOfType(Type $type): bool
    {
        return $type instanceof FloatType;
    }

    protected function isOfTypeName(string $typeName): bool
    {
        return in_array($typeName, [$this->getName(), 'double'], true);
    }
}
