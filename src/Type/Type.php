<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;

/**
 * Describes a Type.
 */
interface Type extends Equatable
{
    /**
     * Check type inheritance.
     * 
     * True if this type is:
     * - the same as the given type
     * - derived from the given type
     * 
     * @param Type $type The type to check.
     * @return boolean
     */
    function is(Type $type): bool;

    /**
     * Determines if the given value is of this type.
     *
     * @param mixed $value The value to check.
     * @return boolean
     */
    function isValueOfType($value): bool;
}