<?php
declare( strict_types = 1 );

namespace PHP\Hashing;

use PHP\Collections\ByteArray;

/**
 * Describes an Object that provides its own Hash sum
 * 
 * When paired with IEquatable, the results should be equivalent. If x.equals(y) returns true, then the value returned
 * by the x.hash() should be equal to y.hash().
 */
interface IHashable
{

    /**
     * Retrieve the Hash Sum of this value
     * 
     * @return ByteArray
     */
    public function hash(): ByteArray;
}