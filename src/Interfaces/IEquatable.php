<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

/**
 * Describes Object equality comparison
 */
interface IEquatable
{

    /**
     * Determines if this Object is equal to another value
     * 
     * @param mixed $value The value to compare this to
     * @return bool
     */
    public function equals( $value ): bool;
}