<?php
namespace PHP\Types;

/**
 * Retrieve type information from a function instance
 */
final class FunctionReferenceType extends FunctionType
{
    
    /**
     * Reflection instance with details for the function instance
     *
     * @var \ReflectionFunctionAbstract
     */
    private $function;
    
    
    /**
     * Create a new type instance for this function definition
     *
     * @param \ReflectionFunctionAbstract $function Reflection instance for the function
     */
    public function __construct( \ReflectionFunctionAbstract $function )
    {
        parent::__construct();
        $this->function = $function;
    }
}
