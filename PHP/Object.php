<?php
namespace PHP;

/**
 * Base definition for all Object instances
 */
class Object implements Object\ObjectDefinition
{
    
    final public function GetType(): string
    {
        return get_class( $this );
    }
}
