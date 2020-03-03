<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types;

use PHP\Types\TypeLookup;
use PHPUnit\Framework\TestCase;

/**
 * Defines some utility methods for Type Tests
 */
class TypeTestCase extends TestCase
{


    /**
     * Retrieve a (singleton) instance of the TypeLookup
     * 
     * @return TypeLookup
     */
    final protected function getTypeLookup(): TypeLookup
    {
        static $typeLookup = null;
        if ( null === $typeLookup ) {
            $typeLookup = new TypeLookup();
        }
        return $typeLookup;
    }
}