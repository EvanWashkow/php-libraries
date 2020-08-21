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
                $this->createSerializer( function() { return ''; } ),
                $this->createHashAlgorithm( function() { return new ByteArray( '' ); } )
            ),
            'SerializingHasher is not an instance of IHasher.'
        );
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