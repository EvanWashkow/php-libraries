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
     * @param mixed $value The value to check.
     * @return boolean
     */
    function isValueOfType($value): bool;
}