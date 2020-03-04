<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Defines function type information
 */
class FunctionType extends Type
{

    /**
     * Create a new type instance representing a function type
     */
    public function __construct()
    {
        parent::__construct( TypeNames::FUNCTION );
    }
}