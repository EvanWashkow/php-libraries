<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\TypeInterface;

use EvanWashkow\PHPLibraries\EquatableInterface;

/**
 * Describes a Type.
 */
interface TypeInterface extends EquatableInterface
{
    /**
     * Determines if the given value is of this type.
     *
     * @param mixed $value the value to check
     */
    public function isValueOfType($value): bool;
}
