<?php
namespace PHP\Types;

/**
 * Base definition for all Object instances
 */
class Object implements ObjectDefinition
{
    
    final public function GetType(): string
    {
        return get_class( $this );
    }
}
