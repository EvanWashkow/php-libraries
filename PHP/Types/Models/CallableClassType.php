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
        // Set own properties
        $reflectionMethod   = $reflectionClass->getMethod( '__invoke' );
        $this->callableType = new CallableType( $reflectionMethod );
        $this->classType    = new ClassType(    $reflectionClass );

        // Set parent properties
        $aliases = array_merge(
            $this->classType->getNames()->toArray(),
            $this->callableType->getNames()->toArray()
        );
        parent::__construct( $this->classType->getName(), $aliases );
    }
}
