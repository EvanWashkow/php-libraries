<?php
declare(strict_types=1);

namespace PHP\Type\Model;

/**
 * Defines a string type
 */
class StringType extends Type
{
    public function __construct()
    {
        parent::__construct('string');
    }

    final public function isValueOfType($value): bool
    {
        return is_string($value);
    }

    final protected function isOfType(Type $type): bool
    {
        return $this->isOfTypeName($type->getName());
    }

    final protected function isOfTypeName(string $typeName): bool
    {
        return $typeName === $this->getName();
    }
}
