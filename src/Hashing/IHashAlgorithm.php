<?php
declare( strict_types = 1 );

namespace PHP\Hashing;

use PHP\Collections\ByteArray;

/**
 * Defines a Hash Algorithm
 */
interface IHashAlgorithm
{

    /**
     * Compute the hash of the Byte Array, returning the result
     * 
     * @return ByteArray
     */
    public function hash( ByteArray $byteArray ): ByteArray;
}