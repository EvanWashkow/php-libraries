<?php
namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Defines the base type for a function
 */
class FunctionBaseType extends CallableBaseType
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
