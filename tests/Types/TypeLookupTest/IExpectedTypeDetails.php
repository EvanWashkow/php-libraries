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
     * Return the expected Type::class (class name) as a string
     * 
     * @return string
     */
    public function getTypeClassName(): string;
}