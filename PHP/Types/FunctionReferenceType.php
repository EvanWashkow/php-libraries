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
        // @todo Use \PHP\Types::GetByValue() to determine if the item is a Type instance
        return (
            is_a( $item, self::class ) &&
            ( $item->getFunctionName() === $this->getFunctionName() )
        );
    }
}
