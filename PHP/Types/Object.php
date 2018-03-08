<?php
namespace PHP\Types;

/**
 * Base definition for all Object instances
 */
class Object
{
    
    /**
     * Determines if the given value is equal to this one
     *
     * Extend this to return more accurate results for custom objects
     *
     * @param mixed $value The value to compare this object to
     * @return bool
     */
    public function Equals( $value ): bool
    {
        return ( $this === $value );
    }
    
    
    /**
     * Retrieve namespaced class string for this type
     *
     * @return string
     */
    final public function GetType(): string
    {
        return get_class( $this );
    }
}
