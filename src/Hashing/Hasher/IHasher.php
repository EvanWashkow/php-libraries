<?php
declare( strict_types = 1 );

namespace PHP\Hashing\Hasher;

use PHP\Collections\ByteArray;

/**
 * Calculates the Hash Sum for any value, using a combination of Formatters, Hash Algorithms, and etc. to do so
 */
interface IHasher
{

    /**
     * Calculate the hash of the given value, returning the result
     * 
     * @param mixed $value The value to hash
     * @return ByteArray
     */
    public function hash( $value ): ByteArray;
}