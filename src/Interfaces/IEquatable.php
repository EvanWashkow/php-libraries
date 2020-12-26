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
     * Rules:
     * 
     * Object equality should not change over time. This is not logically correct. 1 is always equal to 1, it never
     * equals 2. Incrementing it by 1 _does not change its value_ to 2: it produces a _new_ value, 2. Changes to an
     * Object that would affect its equality should instead return a new, different Object. (Do not recycle Objects:
     * it's a bad habit).
     * 
     * @param mixed $value The value to compare this to
     * @return bool
     */
    public function equals( $value ): bool;


    /**
     * Retrieves the hash sum for this Object.
     * 
     * Rules:
     * 
     * Hashes serve as an Object's fingerprint. Thus, they must not change over the Object's lifetime. If an Object is
     * contained in a Collection, any change to its hash would cause it to be lost in the Collection's hash table.
     * 
     * If x.equals(y) returns true, then x.hash() must equal y.hash(). However, the inverse is not necessarily true.
     * If x.hash() equals y.hash(), this does not mean that x.equals(y). Hashes are not guaranteed to be unique;
     * however, the more unique they are, the faster they can be retrieved from Collections.
     * 
     * @internal
     * Suggestions for Implementers:
     * 
     * Either compute the hash from immutable fields, or, if there are none, return a new Object with the change.
     * See equals().
     * 
     * @return ByteArray
     */
    public function hash(): ByteArray;
}