<?php
namespace PHP\Types\Models;

use PHP\Types\TypeNames;


/**
 * Defines a type that can be executed as a function
 */
final class CallableType extends CallableBaseType
{

    /** @var \ReflectionFunctionAbstract $reflectionFunctionAbstract Reflection of the callable instance */
    private $reflectionFunctionAbstract;
    
    
    /**
     * Create a new callable type instance
     *
     * @param \ReflectionFunctionAbstract $reflectionFunctionAbstract Reflection of the callable instance
     * @param string $name The primary type name
     */
    public function __construct(
        \ReflectionFunctionAbstract $reflectionFunctionAbstract,
        string $name = TypeNames::CALLABLE )
    {
        parent::__construct( $name );
        $this->reflectionFunctionAbstract = $reflectionFunctionAbstract;
    }
}
