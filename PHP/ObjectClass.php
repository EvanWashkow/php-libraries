<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Interfaces\Cloneable;
use PHP\Interfaces\Equatable;

/**
 * Defines a basic object
 */
class ObjectClass implements Cloneable, Equatable
{

    /**
     * Duplicate this object
     * 
     * @return ObjectClass
     */
    public function clone(): Cloneable
    {
        return clone $this;
    }


    /**
     * Determine if this object equals another object
     * 
     * @return bool
     */
    public function equals( $value ): bool
    {
        return $this === $value;
    }
}