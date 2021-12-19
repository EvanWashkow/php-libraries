<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries;

/**
 * Describes Object equality comparison.
 */
interface Equatable
{
    /**
     * Compare values for equality.
     * 
     * - Determines if an object is _exactly_ equal to the given value.
     * - Object equality must be idempotent. Internal changes to an object must not affect its equality; return a new
     * value instead.
     * 
     * @param mixed $value The value to compare.
     * @return boolean
     */
    function equals($value): bool;
}