<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Type;

use EvanWashkow\PhpLibraries\Equatable;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * A String Type.
 */
final class StringType implements Type
{
    public function equals(Equatable $value): bool
    {
        return $value instanceof self;
    }

    public function isValueOfType(mixed $value): bool
    {
        return is_string($value);
    }
}
