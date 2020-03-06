<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\Type;

abstract class TypeDetails
{

    /**
     * Return the expected Type->getNames() as an array
     * 
     * @return string[]
     */
    abstract public function getNames(): array;

    /**
     * Return the expected classes / interface names for a Type instance
     * 
     * @return string[]
     */
    public function getTypeNames(): array
    {
        return [ Type::class ];
    }
}