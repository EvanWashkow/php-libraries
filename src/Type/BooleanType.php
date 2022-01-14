<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * A Boolean Type.
 */
final class BooleanType implements TypeInterface
{
    public function equals($value): bool
    {
        return $value instanceof self;
    }

    public function is(TypeInterface $type): bool
    {
        return $type instanceof self;
    }

    public function isValueOfType($value): bool
    {
        return is_bool($value);
    }
}
