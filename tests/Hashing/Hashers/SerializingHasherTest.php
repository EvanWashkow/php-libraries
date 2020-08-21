<?php
declare( strict_types = 1 );

namespace PHP\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\Hashing\HashAlgorithms\IHashAlgorithm;
use PHP\Hashing\Hashers\IHasher;
use PHP\Hashing\Hashers\SerializingHasher;
use PHP\Serialization\ISerializer;
use PHPUnit\Framework\TestCase;

/**
 * Tests SerializingHasher
 */
class SerializingHasherTest extends TestCase
{


    /**
     * Test Inheritance
     */
    public function testInheritance()
    {
        $this->assertInstanceOf(
            IHasher::class,
            new SerializingHasher(
                $this->createReflectingSerializer(),
                $this->createReflectingHashAlgorithm()
            ),
            'SerializingHasher is not an instance of IHasher.'
        );
    }


    /**
     * Test hash()
     * 
     * @dataProvider getHashTestData
     */
    public function testHash( ISerializer $serializer, IHashAlgorithm $hashAlgorithm, $value, string $expected )
    {
        $this->assertEquals(
            $expected,
            ( new SerializingHasher( $serializer, $hashAlgorithm ))->hash( $value )->__toString(),
            'SerializingHasher->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        // Hash Algorithms
        $reflectingHashAlgorithm = $this->createReflectingHashAlgorithm();

        // Serializers
        $reflectingSerializer = $this->createReflectingSerializer();

        // Test Data
        return [
            'reflecting serializer, reflecting hash algorithm' => [
                $reflectingSerializer,
                $reflectingHashAlgorithm,
                'Hello, World!',
                'Hello, World!'
            ]
        ];
    }


    /**
     * Create a Hash Algorithm instance that returns the Byte Array it was passed
     * 
     * @return IHashAlgorithm
     */
    private function createReflectingHashAlgorithm(): IHashAlgorithm
    {
        return $this->createHashAlgorithm( function( ByteArray $byteArray ) { return $byteArray; } );
    }


    /**
     * Create a HashAlgorithm instance
     * 
     * @param \Closure $hash The hash() function callback
     * @return IHashAlgorithm
     */
    private function createHashAlgorithm( \Closure $hash ): IHashAlgorithm
    {
        $hashAlgorithm = $this->createMock( IHashAlgorithm::class );
        $hashAlgorithm->method( 'hash' )->willReturnCallback( $hash );
        return $hashAlgorithm;
    }


    /**
     * Create a Serializer instance that returns the string value it was passed
     * 
     * @return ISerializer
     */
    private function createReflectingSerializer(): ISerializer
    {
        return $this->createSerializer( function( string $string ) { return $string; } );
    }


    /**
     * Create a Serializer instance
     * 
     * @param \Closure $serialize The serialize() function callback
     * @return ISerializer
     */
    private function createSerializer( \Closure $serialize ): ISerializer
    {
        $serializer = $this->createMock( ISerializer::class );
        $serializer->method( 'serialize' )->willReturnCallback( $serialize );
        return $serializer;
    }
}