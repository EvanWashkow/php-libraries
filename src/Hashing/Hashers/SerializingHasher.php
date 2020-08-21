<?php
declare( strict_types = 1 );

namespace PHP\Hashing\Hashers;

use PHP\Collections\ByteArray;
use PHP\Hashing\HashAlgorithms\IHashAlgorithm;
use PHP\Hashing\Hashers\IHasher;
use PHP\Serialization\ISerializer;

/**
 * Serializes a given value and uses a Hash Algorithm compute its hash
 */
class SerializingHasher implements IHasher
{


    /**
     * Create a new Serializing Hash Algorithm
     * 
     * @param ISerializer $serializer       The Serializer to format the value
     * @param IHashAlgorithm $hashAlgorithm The Hash Algorithm to compute the Hash
     */
    public function __construct( ISerializer $serializer, IHashAlgorithm $hashAlgorithm )
    {
        
    }


    public function hash( $value ): ByteArray
    {
        return new ByteArray( '' );
    }
}