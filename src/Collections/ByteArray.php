<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Byte;
use PHP\Collections\Iteration\Iterator;
use PHP\Exceptions\NotImplementedException;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;

/**
 * Defines an array of Bytes
 */
class ByteArray extends ObjectClass implements IArrayable, IReadOnlyCollection, IStringable
{


    /**
     * Create a new ByteArray instance
     *
     * @param string $bytes The String typecast of the Byte Array
     **/
    public function __construct( string $bytes )
    {
        return;
    }


    /**
     * Type-casts this Byte Array to a String, and returns the result.
     * 
     * This does not return a Hexidecimal String representation of this Byte Array. It type-casts the bits to a string.
     * (This is the native way PHP represents byte arrays). Character encoding will affect the string's appearance, but
     * not its contents.
     */
    public function __toString(): string
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    /**
     * Retrieve the number of Bytes in this array
     */
    public function count(): int
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    public function getIterator(): Iterator
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }


    /**
     * Retrieve the array of Byte instances
     * 
     * @return Byte[]
     */
    public function toArray(): array
    {
        throw new NotImplementedException( 'Not implemented, yet' );
    }
}