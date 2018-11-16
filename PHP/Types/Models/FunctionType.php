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
     *
     * @param \ReflectionFunction $reflection Reflection of a function
     */
    public function __construct( \ReflectionFunction $reflection = null )
    {
        $aliases = [];
        if ( null !== $reflection ) {
            $aliases[] = $reflection->getName();
        }
        parent::__construct( TypeNames::FUNCTION, $aliases, $reflection );
    }


    /**
     * Retrieve the function name
     *
     * @return string
     **/
    public function getFunctionName(): string
    {
        return $this->getReflection()->getName();
    }
}
