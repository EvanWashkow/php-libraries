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


    /**
     * Test serialize()
     * 
     * @dataProvider getSerializeTestData
     */
    public function testSerialize( $value, string $expected )
    {
        $this->assertEquals(
            $expected,
            ( new PHPSerializer() )->serialize( $value )->__toString(),
            'PHPSerializer->serialize() did not return the expected value.'
        );
    }

    public function getSerializeTestData(): array
    {
        return [
            '0'           => [ 0,           serialize( 0 ) ],
            '1'           => [ 1,           serialize( 1 ) ],
            '2'           => [ 2,           serialize( 2 ) ],
            '[ 1, 2, 3 ]' => [ [ 1, 2, 3 ], serialize( [ 1, 2, 3 ] ) ]
        ];
    }
}