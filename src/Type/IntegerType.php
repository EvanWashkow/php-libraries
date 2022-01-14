<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * An Integer Type.
 */
final class IntegerType implements Type
{
    public function equals($value): bool
    {
        return $value instanceof self;
    }

    public function is(Type $type): bool
    {
        return $type instanceof self;
    }

    public function isValueOfType($value): bool
    {
        return is_int($value);        
    }
}
