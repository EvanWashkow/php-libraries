<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types;

use PHP\Types\TypeLookup;
use PHP\Types\TypeLookupSingleton;
use PHPUnit\Framework\TestCase;

/**
 * Test TypeLookupSingleton
 */
class TypeLookupSingletonTest extends TestCase
{


    /**
     * Test that TypeLookup::getInstance() returns an instance of TypeLookup
     */
    public function testIsTypeLookup()
    {
        $this->assertInstanceOf(
            TypeLookup::class,
            TypeLookupSingleton::getInstance(),
            "TypeLookupSingleton::getInstance() did not return an instance of a TypeLookup."
        );
    }
}