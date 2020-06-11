<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use InvalidArgumentException;
use PHP\Byte;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iteration\Iterator;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;

/**
 * Defines an array of Bytes
 * 
 * @method void __construct( int $bytes )    Create a new Byte Array using the bytes of the given integer
 * @method void __construct( string $bytes ) Create a new Byte Array using the bytes of the given string
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
            throw new InvalidArgumentException( 'ByteArray->__construct() expecting a string or integer' );
        }
    }


    /**
     * Create a new Byte Array instance using the bytes of the given integer
     * 
     * @param  int $bytes      The integer representing the bytes
     * @param ?int $byteLength Truncates the integer to a certain number of bytes, from 1 - 8. NULL = machine-dependent
     * (32-bit = 4 bytes, 64-bit = 8 bytes).
     * @return void
     * @throws \DomainException If the Byte Length is not within 1 - 8
     */
    private function __constructInt( int $bytes, ?int $byteLength = null ): void
    {
        // Interpret the integer as being machine-dependent bytes long
        if ( null === $byteLength ) {
            $bytes = pack( 'I', $bytes );
            $this->__constructString( $bytes );
        }

        // Interpret the integer as being X-number of bytes long
        else {
            if ( ( $byteLength < 1 ) || ( 8 < $byteLength ) ) {
                throw new \DomainException( 'Byte Length must be between 1 and 8.' );
            }

            // Convert the bytes to a string
            $bytes = pack( 'I', $bytes );
            switch ( $byteLength ) {
                case 1:
                    $bytes = $bytes[ 0 ];
                    break;
                case 2:
                    $bytes = $bytes[ 0 ] . $bytes[ 1 ];
                    break;
                default:
                    break;
            }

            // Forward to the string constructor
            $this->__constructString( $bytes );
        }
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