<?php
namespace PHP\Types\Models;

/**
 * Store and retrieve type information for a interface
 */
class InterfaceType extends Type
{
    
    /**
     * Reflection instance with details about the interface
     *
     * @var \ReflectionClass
     */
    private $reflectionClass;
    
    
    /**
     * Create a new type instance representing a interface
     *
     * @param string $className The name of the class
     */
    public function __construct( string $className )
    {
        $this->reflectionClass = new \ReflectionClass( $className );
        parent::__construct( $this->reflectionClass->getName() );
    }


    public function is( string $typeName ): bool
    {
        $typeName = trim( $typeName );
        return (
            ( $this->getName() === $typeName ) ||
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
        return $this->reflectionClass;
    }
}
