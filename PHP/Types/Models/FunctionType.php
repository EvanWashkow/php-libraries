<?php
namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Defines basic information for a "function" type
 */
class FunctionType extends CallableType
{
    
    
    /**
     * Create a new Type representing a function
     */
    public function __construct()
    {
        $aliases = [];
        if ( '' !== $this->getFunctionName() ) {
            $aliases[] = $this->getFunctionName();
        }
        parent::__construct( TypeNames::FUNCTION, $aliases );
    }


    /**
     * Retrieve the function name
     *
     * @return string
     **/
    public function getFunctionName(): string
    {
        return '';
    }
}
