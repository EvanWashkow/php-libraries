<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\EquatableInterface;
use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * A Float Type.
 */
final class FloatType implements TypeInterface
{
    public function equals(EquatableInterface $value): bool
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
