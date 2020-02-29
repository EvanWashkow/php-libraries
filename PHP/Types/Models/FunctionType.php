<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Defines the base type for a function
 */
class FunctionType extends Type
{


    /**
     * Create a new Type representing a function
     */
    public function __construct()
    {
        parent::__construct( TypeNames::FUNCTION );
    }
}
