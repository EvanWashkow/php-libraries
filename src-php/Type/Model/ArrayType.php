<?php
declare(strict_types=1);

namespace PHP\Type\Model;

/**
 * Defines an array type
 */
class ArrayType extends Type
{
    public function __construct()
    {
        parent::__construct('array');
    }


    final public function isValueOfType($value): bool
    {
        return is_array($value);
    }


    final protected function isOfType(Type $type): bool
    {
        return true;
    }


    final protected function isOfTypeName(string $typeName): bool
    {
        return $this->getName() === $typeName;
    }
}