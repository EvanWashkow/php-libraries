<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * An Array type
 */
final class ArrayType implements Type
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
        return is_array($value);
    }
}