<?php
declare(strict_types=1);

/**
 * Describes Object equality comparison.
 */
interface Equatable
{
    /**
     * Compare values for equality.
     * 
     * - Determines if an object is _exactly_ equal to another value.
     * - Internal changes to an object should not change its equality.
     */
    function equals($value): bool;
}