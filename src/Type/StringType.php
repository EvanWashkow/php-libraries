<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * A String Type.
 */
final class StringType implements Type
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
        return is_string($value);
    }
}