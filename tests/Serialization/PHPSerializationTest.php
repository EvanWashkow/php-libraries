<?php
declare( strict_types = 1 );

namespace PHP\Serialization;

use PHP\Collections\ByteArray;
use PHPUnit\Framework\TestCase;

/**
 * Tests the PHPSerializer class
 */
class PHPSerializationTest extends TestCase
{


    /**
     * Test Inheritance
     *
     * @dataProvider getInheritanceTestData
     */
    public function testInheritance(string $class): void
    {
        $this->assertInstanceOf($class, new PHPSerialization());
    }

    public function getInheritanceTestData(): array
    {
        return [
            IDeserializer::class => [IDeserializer::class],
            ISerializer::class   => [ISerializer::class]
        ];
    }


    /**
     * Test serialize()
     * 
     * @dataProvider getSerializeTestData
     */
    public function testSerialize( $value, string $byteArrayString )
    {
        $this->assertEquals(
            $byteArrayString,
            ( new PHPSerialization() )->serialize( $value )->__toString(),
            'PHPSerializer->serialize() did not return the expected value.'
        );
    }


    /**
     * Test deserialize()
     * 
     * @dataProvider getSerializeTestData
     */
    public function testDeserialize( $value, string $byteArrayString )
    {
        $this->assertEquals(
            $value,
            ( new PHPSerialization() )->deserialize( new ByteArray( $byteArrayString ) ),
            'PHPSerializer->deserialize() did not return the expected value.'
        );
    }


    /**
     * Serialization test data
     * 
     * @return array
     */
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