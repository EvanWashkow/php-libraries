<?php
declare( strict_types = 1 );

namespace PHP\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\Hashing\HashAlgorithm\IHashAlgorithm;
use PHP\Hashing\HashAlgorithm\MD5;
use PHP\Serialization\ISerializer;
use PHP\Serialization\PHPSerializer;
use PHPUnit\Framework\TestCase;

/**
 * Tests SerializeAndHash
 */
class SerializeThenApplyHashAlgorithmTest extends TestCase
{


    /**
     * Test Inheritance
     */
    public function testInheritance()
    {
        $this->assertInstanceOf(
            IHasher::class,
            new SerializeThenApplyHashAlgorithm(
                $this->createReflectingSerializer(),
                $this->createReflectingHashAlgorithm()
            ),
            'SerializeAndHash is not an instance of IHasher.'
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
            ( new SerializeThenApplyHashAlgorithm( $serializer, $hashAlgorithm ))->hash( $value )->__toString(),
            'SerializeAndHash->hash() did not return the expected value.'
        );
    }

    public function getHashTestData(): array
    {
        // Value
        $value = 'Hello, World!';

        // Hash Algorithms
        $reflectingHashAlgorithm = $this->createReflectingHashAlgorithm();
        $appendingHashAlgorithm  = $this->createHashAlgorithm( function( ByteArray $byteArray ) {
            return new ByteArray( "{$byteArray}-appending_hash_algorithm" );
        });
        $md5 = new MD5();

        // Serializers
        $reflectingSerializer = $this->createReflectingSerializer();
        $appendingSerializer  = $this->createSerializer( function( string $string ) {
            return new ByteArray( "{$string}-appending_serializer" );
        });
        $phpSerializer = new PHPSerializer();

        /**
         * Test Data
         * 
         * The Serializer should serialize the value before passing it to the Hash Algorithm to be hashed
         */
        return [
            'reflecting serializer, reflecting hash algorithm' => [
                $reflectingSerializer,
                $reflectingHashAlgorithm,
                $value,
                $value
            ],
            'appending serializer, reflecting hash algorithm' => [
                $appendingSerializer,
                $reflectingHashAlgorithm,
                $value,
                "{$value}-appending_serializer"
            ],
            'reflecting serializer, appending hash algorithm' => [
                $reflectingSerializer,
                $appendingHashAlgorithm,
                $value,
                "{$value}-appending_hash_algorithm"
            ],
            'appending serializer, appending hash algorithm' => [
                $appendingSerializer,
                $appendingHashAlgorithm,
                $value,
                "{$value}-appending_serializer-appending_hash_algorithm"
            ],
            'reflecting serializer, MD5' => [
                $reflectingSerializer,
                $md5,
                $value,
                $md5->hash( new ByteArray( $value ) )->__toString()
            ],
            'php serializer, reflecting hash algorithm' => [
                $phpSerializer,
                $reflectingHashAlgorithm,
                $value,
                $phpSerializer->serialize( $value )->__toString()
            ],
            'php serializer, MD5 for "Hello, World!"' => [
                $phpSerializer,
                $md5,
                $value,
                $md5->hash( $phpSerializer->serialize( $value ) )->__toString()
            ],
            'php serializer, MD5 for 0' => [
                $phpSerializer,
                $md5,
                0,
                $md5->hash( $phpSerializer->serialize( 0 ) )->__toString()
            ],
            'php serializer, MD5 for [ 1, 2, 3 ]' => [
                $phpSerializer,
                $md5,
                [ 1, 2, 3 ],
                $md5->hash( $phpSerializer->serialize( [ 1, 2, 3 ] ) )->__toString()
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
     * Create a Serializer instance that returns the string it was passed, as a Byte Array
     * 
     * @return ISerializer
     */
    private function createReflectingSerializer(): ISerializer
    {
        return $this->createSerializer( function( string $string ) { return new ByteArray( $string ); } );
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