<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

interface IExpectedTypeDetails
{

    /**
     * Return the expected Type->getNames() as an array
     * 
     * @return string[]
     */
    public function getNames(): array;

    /**
     * Return the expected classes / interface names for a Type instance
     * 
     * @return string[]
     */
    public function getTypeNames(): array;
}