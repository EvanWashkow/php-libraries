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
     * @internal Can't use "==" in any fashion. "==" does implicitly converts
     * types if the object does not have strictly typed properties. For example,
     * Value->value = '1' and Value->value = 1 are considered equal (==) to
     * eachother.
     * 
     * @return bool
     */
    public function equals( $value ): bool
    {
        return $this === $value;
    }
}