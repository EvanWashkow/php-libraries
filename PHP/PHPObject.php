<?php
namespace PHP;

/**
 * Base definition for all PHPObject instances
 */
class PHPObject implements PHPObjectSpec
{
    
    final public function getType(): string
    {
        return get_class( $this );
    }
}
