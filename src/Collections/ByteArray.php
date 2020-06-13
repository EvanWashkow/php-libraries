<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Byte;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iteration\Iterator;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;

/**
 * Defines an array of Bytes
 * 
 * @method void __construct( int $bytes, int $byteSize = PHP_INT_SIZE ) Create a new Byte Array using the bytes of the given integer
 * @method void __construct( string $bytes )                              Create a new Byte Array using the bytes of the given string
 */
class ByteArray extends ObjectClass implements IArrayable, IReadOnlyCollection, IStringable
{

    /** @var string $bytes The String-typecast representation of the Byte Array */
    private $bytes;


    public function __construct( $bytes )
    {
        if ( is_int( $bytes )) {
            $args = func_get_args();
            $this->__constructInt( ...$args );
        }
        elseif ( is_string( $bytes )) {
            $this->__constructString( $bytes );
        }
        else {
            throw new \InvalidArgumentException( 'ByteArray->__construct() expecting a string or integer' );
        }
    }


    /**
     * Create a new Byte Array instance using the bytes of the given integer
     * 
     * @param int $bytes    The integer representing the bytes
     * @param int $byteSize Treats the integer as N number of bytes long, from 1 to PHP_INT_SIZE bytes in length.
     * PHP_INT_SIZE is determined by the machine's architecture byte size---4 bytes for 32-bit machines, and 8 bytes for
     * 64-bit machines---as it is impossible to define an integer outside this range.
     * @return void
     * @throws \DomainException If the Byte Length is not within 1 to PHP_INT_SIZE
     */
    private function __constructInt( int $bytes, int $byteSize = PHP_INT_SIZE ): void
    {
        // Ensure Byte Length range is valid
        if ( ( $byteSize < 1 ) || ( PHP_INT_SIZE < $byteSize ) ) {
            throw new \DomainException( 'Byte Length must be between 1 and PHP_INT_SIZE.' );
        }

        // Convert the bytes to a string
        $byteString = pack( 'Q', $bytes );

        // Treat the integer as N number of bytes long, truncating the rest
        $byteStringBuilder = '';
        for ( $i = 0; $i < $byteSize; $i++ ) { 
            $byteStringBuilder .= $byteString[ $i ];
        }
        $byteString = $byteStringBuilder;

        // Forward the resulting Byte string to the string constructor
        $this->__constructString( $byteString );
    }


    /**
     * Create a new Byte Array instance using the bytes of the given string
     * 
     * @param string $bytes The string representing the bytes
     * @return void
     */
    private function __constructString( string $bytes ): void
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
        $bytesAsIntsArray = unpack( 'C*', $this->__toString() );
        foreach ( $bytesAsIntsArray as $byteAsInt ) {
            $bytes[] = new Byte( $byteAsInt );
        }
        return $bytes;
    }
}