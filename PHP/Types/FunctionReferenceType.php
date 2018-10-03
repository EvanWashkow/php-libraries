<?php
namespace PHP\Types;

/**
 * Retrieve type information from a function instance
 */
final class FunctionReferenceType extends FunctionType
{
    
    /** @var \ReflectionFunctionAbstract $function Reflection instance with details for the function instance */
    private $function = null;
    
    
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


    public function getFunctionName(): string
    {
        return $this->function->getName();
    }
}
