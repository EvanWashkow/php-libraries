<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * An Array Type.
 */
final class ArrayType implements Type
{
    public function equals(Equatable $value): bool
    {
        return $value instanceof self;
    }

    public function isValueOfType(mixed $value): bool
    {
        return is_array($value);
    }
}
