<?php
declare(strict_types=1);

namespace PHP\Hashing\Hasher;

use PHP\Collections\ByteArray;

/**
 * Describes a class that computes the hash sum for a value, regardless of type.
 */
interface IHasher
{


    /**
     * Compute the hash sum for a value, regardless of its type.
     *
     * @param mixed $value The value to compute the hash sum of
     * @return ByteArray
     */
    public function hash($value): ByteArray;
}