<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

/**
 * Store and retrieve type information for a class
 */
final class ClassType extends InterfaceType
{


    final public function is( string $typeName ): bool
    {
        $typeName = trim( $typeName );
        return (
            parent::is( $typeName ) ||
            (
                class_exists( $typeName ) &&
                $this->getReflectionClass()->isSubclassOf( $typeName )
            )
        );
    }
    
    
    final public function isClass(): bool
    {
        return true;
    }
    
    
    final public function isInterface(): bool
    {
        return false;
    }
}