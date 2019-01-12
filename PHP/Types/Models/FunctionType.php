<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

/**
 * Retrieve type information from a function instance
 */
final class FunctionType extends FunctionBaseType
{

    /** @var string $name The function name */
    private $name;
    
    
    /**
     * Create a new type instance for this function definition
     *
     * @param string $name The function name
     */
    public function __construct( string $name )
    {
        $this->name = $name;
        parent::__construct();
    }




    /***************************************************************************
    *                                   PROPERTIES
    ***************************************************************************/


    public function getFunctionName(): string
    {
        return $this->name;
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
}
