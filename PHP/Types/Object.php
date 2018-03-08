<?php
namespace PHP\Types;

/**
 * Base definition for all Object instances
 */
class Object
{
    
    /**
     * Retrieve namespaced string of this object's class type
     *
     * @return string
     */
    final public function GetType(): string
    {
        return get_class( $this );
    }
}
