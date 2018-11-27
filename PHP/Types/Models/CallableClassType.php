<?php
namespace PHP\Types\Models;

use PHP\Types\TypeNames;


/**
 * Defines a class that can be invoked like a function
 */
final class CallableClassType extends ClassType implements CallableType
{

    /** @var FunctionType $functionType FunctionType instance */
    private $functionType;


    /**
     * Create a new type instance representing a interface
     *
     * @param \ReflectionClass $reflectionClass ReflectionClass instance
     */
    public function __construct( \ReflectionClass $reflectionClass )
    {
        // Set own properties
        $reflectionMethod   = $reflectionClass->getMethod( '__invoke' );
        $this->functionType = new FunctionType( $reflectionMethod );

        // Set parent properties
        parent::__construct( $reflectionClass, [ TypeNames::CALLABLE ] );
    }
}
