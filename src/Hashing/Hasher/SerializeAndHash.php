<?php
declare( strict_types = 1 );

namespace PHP\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\Hashing\HashAlgorithm\IHashAlgorithm;
use PHP\Hashing\Hasher\IHasher;
use PHP\Serialization\ISerializer;

/**
 * Serializes a given value and uses a Hash Algorithm compute its hash
 */
class SerializeAndHash implements IHasher
{

    /** @var IHashAlgorithm $hashAlgorithm The Hash Algorithm to compute the Hash */
    private $hashAlgorithm;

    /** @var ISerializer $serializer The Serializer to serialize the value before hashing it */
    private $serializer;


    /**
     * Create a new Serializing Hash Algorithm
     * 
     * @param ISerializer    $serializer    The Serializer to serialize the value before hashing it
     * @param IHashAlgorithm $hashAlgorithm The Hash Algorithm to compute the Hash
     */
    public function __construct( ISerializer $serializer, IHashAlgorithm $hashAlgorithm )
    {
        $this->serializer    = $serializer;
        $this->hashAlgorithm = $hashAlgorithm;
    }


    final public function hash( $value ): ByteArray
    {
        return $this->hashAlgorithm->hash(
            $this->serializer->serialize( $value )
        );
    }
}