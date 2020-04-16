<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

/**
 * Determines if one object is equal to another object or value
 */
interface IEquatable
{

    /**
     * Determine if this object is the same as another object or value
     * 
     * @param mixed $value The value to compare this to
     * @return bool
     */
    public function equals( $value ): bool;
}