<?php

declare(strict_types=1);

namespace PHP\Tests\Types;

use PHP\Types\TypeLookup;
use PHP\Types\TypeLookupSingleton;
use PHPUnit\Framework\TestCase;

/**
 * Test TypeLookupSingleton.
 *
 * @internal
 * @coversNothing
 */
class TypeLookupSingletonTest extends TestCase
{
    /**
     * Test that TypeLookupSingleton::getInstance() returns an instance of TypeLookup.
     */
    public function testIsTypeLookup()
    {
        $this->assertInstanceOf(
            TypeLookup::class,
            TypeLookupSingleton::getInstance(),
            'TypeLookupSingleton::getInstance() did not return an instance of a TypeLookup.'
        );
    }

    /**
     * Test that multiple calls to TypeLookupSingleton::getInstance() returns the same instance.
     */
    public function testIsSingletonInstance()
    {
        $this->assertTrue(
            TypeLookupSingleton::getInstance() === TypeLookupSingleton::getInstance(),
            'Multiple calls to TypeLookupSingleton::getInstance() did not return the same instance.'
        );
    }
}
