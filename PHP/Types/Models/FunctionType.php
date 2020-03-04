<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Retrieve type information for a function
 */
class FunctionType extends Type
{

    /**
     * Create a function type representation to retrieve information from
     */
    public function __construct()
    {
        parent::__construct( TypeNames::FUNCTION );
    }
}