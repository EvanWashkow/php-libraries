<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types;

use PHP\Types\TypeLookupSingleton;
use PHPUnit\Framework\TestCase;

/**
 * Defines some utility methods for Type Tests
 */
class TypeTestCase extends TestCase
{


    /**
     * Retrieve a (singleton) instance of the TypeLookup
     * 
     * @return TypeLookupSingleton
     */
    final protected function getTypeLookup(): TypeLookupSingleton
    {
        return TypeLookupSingleton::getInstance();
    }
}