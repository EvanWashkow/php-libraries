<?php
namespace PHP;

/**
 * Base definition for all Object instances
 */
class Object implements ObjectSpec
{
    
    final public function GetType(): string
    {
        return get_class( $this );
    }
}
