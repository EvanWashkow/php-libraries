<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

/**
 * Retrieve type information from a function instance
 */
class FunctionInstanceType extends FunctionType
{
    
    /** @var \ReflectionFunctionAbstract $reflectionFunction Reflection instance with details for the function instance */
    private $reflectionFunction;
    
    
    /**
     * Create a new type instance for this function definition
     *
     * @param \ReflectionFunctionAbstract $reflectionFunction Reflection instance for the function
     */
    public function __construct( \ReflectionFunctionAbstract $reflectionFunction )
    {
        $this->reflectionFunction = $reflectionFunction;
        parent::__construct();
    }




    /***************************************************************************
    *                                   PROPERTIES
    ***************************************************************************/


    public function getFunctionName(): string
    {
        return $this->reflectionFunction->getName();
    }




    /***************************************************************************
    *                                 COMPARISON
    ***************************************************************************/


    public function equals( $item ): bool
    {
        return (
            is_a( $item, self::class ) &&
            ( $this->getFunctionName() === $item->getFunctionName() )
        );
    }
}
