<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries;

/**
 * Describes Object equality comparison.
 * 
 * - Equality must compare two values for equivalence and should not be used for other behavior.
 * - An object must be equivalent to itself.
 * - Equality must be bi-directional. Calling `equals()` on the opposing object should result in the same value.
 * - Equality must be idempotent. Internal changes should not affect an object's equality; return a new value instead.
 */
interface EquatableInterface
{
    /**
     * Compare values for equality.
     * 
     * @param mixed $value The value to compare.
     * @return boolean
     */
    function equals($value): bool;
}