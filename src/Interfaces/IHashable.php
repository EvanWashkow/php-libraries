<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

use PHP\Collections\ByteArray;

/**
 * Describes an object that, when called, calculates its own hash.
 * 
 * When paired with IEquatable, both should return consistent results. If x.equals(y) should be true, then x.hash() must
 * be equal to y.hash(). More formally, x.equals( y ) === ( x.hash() === y.hash() ).
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