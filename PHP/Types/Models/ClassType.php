<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

/**
 * Store and retrieve type information for a class
 */
final class ClassType extends InterfaceType
{
    
    
    final public function isClass(): bool
    {
        return true;
    }
    
    
    final public function isInterface(): bool
    {
        return false;
    }
}