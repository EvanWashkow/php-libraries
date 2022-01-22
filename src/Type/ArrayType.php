<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * An Array Type.
 */
final class ArrayType implements TypeInterface
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
        return is_array($value);
    }
}