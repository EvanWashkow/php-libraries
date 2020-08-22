<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

use PHP\Collections\ByteArray;

/**
 * Describes Object equality comparison
 */
interface IEquatable
{

    /**
     * Determines if this Object is equal to another value
     * 
     * @param mixed $value The value to compare this to
     * @return bool
     */
    public function equals( $value ): bool;


    /**
     * Retrieves the hash sum for this Object
     * 
     * Rules:
     * 
     * If x.equals(y) returns true, then x.hash() must equal y.hash(). However, the inverse is not necessarily true.
     * If x.hash() equals y.hash(), this does not mean that x.equals(y). Hashes are not guaranteed to be unique;
     * however, the more unique they are, the faster they can be retrieved from Collections.
     *
     * An Object's hash must not change over its lifetime. If an Object is contained in a Collection, any change to its
     * hash would cause it to be lost in the Collection's hash table. Either compute the hash from immutable fields, or,
     * if there are none, return a new Object with the change. (It is good to get out of the habit of recycling Objects.
     * An Object's equality should not change over time: it is not mathmatically or logically correct. For example,
     * 1 always equals 1. Incrementing 1 does not change its value, rather, it produces a new value, 2.)
     * 
     * @return ByteArray
     */
    public function hash(): ByteArray;
}