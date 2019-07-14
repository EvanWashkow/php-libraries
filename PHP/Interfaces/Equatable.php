<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

/**
 * Determines if one object is equal to another object or value
 */
interface Equatable
{

    /**
     * Determine if the value is the same as the current object
     * 
     * @param mixed $value The value to compare this to
     * 
     * @return bool
     */
    public function equals( $value ): bool;
}