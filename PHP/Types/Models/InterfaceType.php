<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

/**
 * Store and retrieve type information for a interface
 */
class InterfaceType extends Type
{

    /** @var \ReflectionClass  Reflection instance with details about the interface */
    private $reflectionClass;


    /**
     * Create a new type instance representing a interface
     *
     * @param string $name The interface name
     */
    public function __construct( string $name )
    {
        parent::__construct( $name );
        $this->reflectionClass = null;
    }


    public function is( string $typeName ): bool
    {
        $typeName = trim( $typeName );
        return (
            parent::is( $typeName ) ||
            (
                interface_exists( $typeName ) &&
                $this->getReflectionClass()->isSubclassOf( $typeName )
            )
        );
    }
    
    
    public function isInterface(): bool
    {
        return true;
    }


    /**
     * Retrieve the reflection class instance
     *
     * @return \ReflectionClass
     **/
    final protected function getReflectionClass(): \ReflectionClass
    {
        if ( null === $this->reflectionClass ) {
            $this->reflectionClass = new \ReflectionClass( $this->getName() );
        }
        return $this->reflectionClass;
    }
}
