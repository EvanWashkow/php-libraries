<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * An Array Type.
 */
final class ArrayType implements TypeInterface
{
    /**
     * @inheritDoc
     */
    public function equals($value): bool
    {
        return $value instanceof self;
    }

    /**
     * @inheritDoc
     */
    public function isValueOfType($value): bool
    {
        return is_array($value);
    }
}
