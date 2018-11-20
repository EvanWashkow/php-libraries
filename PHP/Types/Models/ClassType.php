<?php
namespace PHP\Types\Models;

/**
 * Store and retrieve type information for a class
 */
final class ClassType extends InterfaceType implements IClassType
{


    public function is( string $typeName ): bool
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
    
    
    public function isClass(): bool
    {
        return true;
    }
    
    
    public function isInterface(): bool
    {
        return false;
    }
}