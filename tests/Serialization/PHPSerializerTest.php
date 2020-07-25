<?php
declare( strict_types = 1 );

namespace PHP\Serialization;

use PHPUnit\Framework\TestCase;

/**
 * Tests the PHPSerializer class
 */
class PHPSerializerTest extends TestCase
{


    /**
     * Test Inheritance
     */
    public function testInheritance()
    {
        $this->assertInstanceOf(
            ISerializer::class,
            new PHPSerializer()
        );
    }
}