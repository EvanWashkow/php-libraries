<?php
namespace PHP\Types\Models;

/**
 * Retrieve type information from a function instance
 */
final class CallableFunctionType extends FunctionType
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
        $this->function = $function;
        parent::__construct();
    }




    /***************************************************************************
    *                                   PROPERTIES
    ***************************************************************************/


    public function getFunctionName(): string
    {
        return $this->function->getName();
    }




    /***************************************************************************
    *                                 COMPARISON
    ***************************************************************************/


    public function equals( $item ): bool
    {
        $type = \PHP\Types::GetByValue( $item );
        return (
            $type->is( self::class ) &&
            ( $item->getFunctionName() === $this->getFunctionName() )
        );
    }
    
    
    public function isCallable(): bool
    {
        return true;
    }
}
