<?php
declare(strict_types=1);

namespace PHP\Type\Model;

/**
 * Anonymous Types define a Type without any strict Type constraints. Rather, the resulting Type is determined at
 * runtime by sniffing the value.
 */
class AnonymousType extends Type
{
    public function __construct()
    {
        parent::__construct('*');
    }

    final public function isValueOfType($value): bool
    {
        return false;
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