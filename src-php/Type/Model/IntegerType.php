<?php
declare(strict_types = 1);

namespace PHP\Type\Model;

/**
 * Defines a integer type
 */
class IntegerType extends Type
{
    public function __construct()
    {
        parent::__construct('integer');
    }


    final public function isValueOfType($value): bool
    {
        return is_int($value);
    }


    final protected function isOfType(Type $type): bool
    {
        return $type instanceof IntegerType;
    }


    final protected function isOfTypeName(string $typeName): bool
    {
        return in_array($typeName, [$this->getName(), 'int'], true);
    }
}
