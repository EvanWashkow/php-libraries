<?php
namespace PHP\Types;

/**
 * Defines basic information for a "function" type
 */
class FunctionType extends Type
{
    
    
    /**
     * Create a new Type representing a function
     */
    public function __construct()
    {
        parent::__construct( 'function' );
    }
}
