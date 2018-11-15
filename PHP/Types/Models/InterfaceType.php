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
     * @param \ReflectionClass $reflectionClass Reflection instance for the interface
     */
    public function __construct( \ReflectionClass $reflectionClass )
    {
        parent::__construct( $reflectionClass->getName() );
        $this->reflectionClass = $reflectionClass;
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
