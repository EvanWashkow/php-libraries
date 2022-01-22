<?php

declare(strict_types=1);

namespace PHP\Hashing\HashAlgorithm;

use PHP\Collections\ByteArray;

/**
 * Calculates the Hash of a Byte Array
 */
interface IHashAlgorithm
{
    /**
     * Compute the hash of the Byte Array, returning the result
     *
     * @return ByteArray
     */
    public function hash(ByteArray $byteArray): ByteArray;
}
