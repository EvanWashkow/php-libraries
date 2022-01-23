<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * A Boolean Type.
 */
final class BooleanType implements TypeInterface
{
    public function equals($value): bool
    {
        return $value instanceof self;
    }

    public function isValueOfType($value): bool
    {
        return is_bool($value);
    }
}
