<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * A Boolean Type.
 */
final class BooleanType implements Type
{
    public function equals(Equatable $value): bool
    {
        return $value instanceof self;
    }

    /**
     * @inheritDoc
     */
    public function isValueOfType(mixed $value): bool
    {
        return is_bool($value);
    }
}
