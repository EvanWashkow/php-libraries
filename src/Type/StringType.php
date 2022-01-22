<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * A String Type.
 */
final class StringType implements TypeInterface
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
        return is_string($value);
    }
}
