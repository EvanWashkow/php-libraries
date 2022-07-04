<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * A Float Type.
 */
final class FloatType implements Type
{
    public function equals(Equatable $value): bool
    {
        return $value instanceof self;
    }

    /**
     * @inheritDoc
     */
    public function isValueOfType($value): bool
    {
        return is_float($value);
    }
}
