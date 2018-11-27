<?php
namespace PHP\Types\Models;

/**
 * Defines a class that can be invoked like a function
 */
class CallableClassType extends Type implements ICallableType, IClassType
{
    
    /** @var CallableType $callableType CallableType instance */
    private $callableType;

    /** @var ClassType $classType CLassType instance */
    private $classType;
    
    
    /**
     * Create a new type instance representing a interface
     *
     * @param \ReflectionClass $reflectionClass ReflectionClass instance
     */
    public function __construct( \ReflectionClass $reflectionClass )
    {
        // Variables
        $className = $reflectionClass->getName();

        // Set own properties
        $reflectionMethod   = $reflectionClass->getMethod( '__invoke' );
        $this->callableType = new CallableType( $reflectionMethod, $className );
        $this->classType    = new ClassType( $reflectionClass );

        // Set parent properties
        $aliases = array_merge(
            $this->classType->getNames()->toArray(),
            $this->callableType->getNames()->toArray()
        );
        parent::__construct( $className, $aliases );
    }


    /**
     * @see IType->equals()
     */
    public function equals( $item ): bool
    {
        return $this->classType->equals( $item );
    }


    /**
     * @see IType->is()
     */
    public function is( string $typeName ): bool
    {
        return (
            $this->callableType->is( $typeName ) |
            $this->classType->is(    $typeName )
        );
    }


    /**
     * @see IType->is()
     */
    public function isClass(): bool
    {
        return true;
    }
}
