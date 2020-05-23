<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Byte;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iteration\Iterator;
use PHP\Exceptions\NotImplementedException;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;

/**
 * Defines an array of Bytes
 */
class ByteArray extends ObjectClass implements IArrayable, IReadOnlyCollection, IStringable
{

    /** @var string $bytes The String-typecast representation of the Byte Array */
    private $bytes;


    /**
     * Create a new ByteArray instance
     *
     * @param string $bytes The String-typecast representation of the Byte Array
     **/
    public function __construct( string $bytes )
    {
        $this->bytes = $bytes;
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
        return $this->bytes;
    }


    /**
     * Retrieve the number of Bytes in this array
     */
    public function count(): int
    {
        return count( $this->toArray() );
    }


    public function getIterator(): Iterator
    {
        return new ArrayableIterator( $this );
    }


    /**
     * Retrieve the array of Byte instances
     * 
     * @return Byte[]
     */
    public function toArray(): array
    {
        $bytes            = [];
        $bytesAsIntsArray = unpack( 'C*', $this->bytes );
        foreach ( $bytesAsIntsArray as $byteAsInt ) {
            $bytes[] = new Byte( $byteAsInt );
        }
        return $bytes;
    }
}