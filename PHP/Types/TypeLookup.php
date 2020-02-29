<?php
declare( strict_types = 1 );

namespace PHP\Types;

use PHP\Types\Models\Type;

/**
 * Retrieves type information based on the type name or value
 */
class TypeLookup
{


    /**
     * Lookup Type information by its name
     *
     * @param string $name The type name
     * @return Type
     * @throws NotFoundException
     */
    public function getByName( string $name ): Type
    {

    }
}
