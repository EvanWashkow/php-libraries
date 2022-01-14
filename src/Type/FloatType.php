<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * A Float Type.
 */
final class FloatType implements Type
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
        return is_float($value);
    }
}
