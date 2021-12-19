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
        return $value instanceof ArrayType;
    }

    public function is(Type $type): bool
    {
        return $type instanceof self;
    }
}