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
    public function getTypeNames(): array;

    /**
     * Return the expected classes / interfaces a Type instance should be
     * 
     * @return string[]
     */
    public function getTypeTypes(): array;
}