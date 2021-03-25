<?php
declare(strict_types = 1);

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


    /**
     * @inheritDoc
     *
     * @interal Always returns false. No other type is derived from this type. Take, for example, integers. Integers are
     * not derived from Anonymous Types. Thus, integer values are also not of this type.
     */
    final public function isValueOfType($value): bool
    {
        return false;
    }


    /**
     * @inheritDoc
     *
     * @todo Implement
     *
     * @interal Only returns true if the type name is equal to this. This type is a derivative of any other type.
     */
    final protected function isOfType(Type $type): bool
    {
        return true;
    }


    /**
     * @inheritDoc
     *
     * @interal Only returns true if the type name is equal to this. This type is a derivative of any other type.
     */
    final protected function isOfTypeName(string $typeName): bool
    {
        return $this->getName() === $typeName;
    }
}
