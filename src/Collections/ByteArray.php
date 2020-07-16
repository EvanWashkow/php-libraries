<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Byte;
use PHP\Collections\Iteration\ArrayableIterator;
use PHP\Collections\Iteration\Iterator;
use PHP\Interfaces\ICloneable;
use PHP\Interfaces\IIntegerable;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;

/**
 * Defines an array of Bytes
 * 
 * @method void __construct( Byte[] $bytes )                               Create a new Byte Array using the bytes of the given Byte[]
 * @method void __construct( double $bytes, int $byteSize = PHP_INT_SIZE ) Create a new Byte Array using the bytes of the given double-precision floating point number
 * @method void __construct( int $bytes, int $byteSize = PHP_INT_SIZE )    Create a new Byte Array using the bytes of the given integer
 * @method void __construct( string $bytes )                               Create a new Byte Array using the bytes of the given string
 */
class ByteArray extends ObjectClass implements IArrayable, ICloneable, IIntegerable, IReadOnlyCollection, IStringable
{


    /*******************************************************************************************************************
    *                                                       CONSTANTS
    *******************************************************************************************************************/

    /** @var string INT_FORMAT pack() format for 64-bit integer */
    private const INT_FORMAT = 'q';

    /** @var string DOUBLE_FORMAT pack() format for 64-bit doubles */
    private const DOUBLE_FORMAT = 'd';




    /*******************************************************************************************************************
    *                                                      PROPERTIES
    *******************************************************************************************************************/

    /** @var string $bytes The String-typecast representation of the Byte Array */
    private $bytes;





    /*******************************************************************************************************************
    *                                                      CONSTRUCTOR
    *******************************************************************************************************************/


    /**
     * @throws \InvalidArgumentException If bytes is not a Byte[], integer, or string
     * @throws \DomainException          If bytes is an integer, and the byteSize < 0
     */
    public function __construct( $bytes )
    {
        // Switch on variable type
        if ( is_array( $bytes )) {
            try {
                $this->__constructByteArray( ...$bytes );
            } catch ( \TypeError $te ) {
                throw new \InvalidArgumentException( 'ByteArray->__construct() expecting a Byte[]. An element in the array was not a Byte.' );
            }
        }
        elseif ( is_string( $bytes )) {
            $this->__constructString( $bytes );
        }
        elseif (
            ( $isInt    = is_int(    $bytes ) ) ||
            ( $isDouble = is_double( $bytes ) )
        )
        {
            $args       = func_get_args();
            $packFormat = $isInt ? self::INT_FORMAT : self::DOUBLE_FORMAT;
            try {
                $byteString = $this->pack( $packFormat, ...$args );
            } catch ( \DomainException $de ) {
                throw new \DomainException( $de->getMessage(), $de->getCode(), $de );
            }
            $this->__constructString( $byteString );
        }
        else {
            throw new \InvalidArgumentException( 'ByteArray->__construct() expects a Byte[], integer, or string.' );
        }
    }


    /**
     * Create a new Byte Array instance using the given Byte[]
     * 
     * @param Byte ...$bytes The Byte[] representing the bytes
     * @return void
     */
    private function __constructByteArray( Byte ...$bytes ): void
    {
        $byteString = '';
        foreach ( $bytes as $byte ) {
            $byteString .= $this->pack( self::INT_FORMAT, $byte->toInt(), 1 );
        }
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
     * Pack the value with the given format, truncating / padding it be a fixed Byte Size
     * 
     * @param string $packFormat The pack() function's format string
     * @param mixed  $value      The value to pack
     * @param int    $byteSize   Fixes the resulting binary string to be N number of Bytes long, truncating or padding with 0x00 as necessary. Defaults to the current architecture's byte size.
     * @throws \DomainException If the Byte Size < 0
     */
    private function pack( string $packFormat, $value, int $byteSize = PHP_INT_SIZE ): string
    {
        // Ensure Byte Size range is valid
        if ( $byteSize < 0 ) {
            throw new \DomainException( 'Byte Size cannot be less than 0.' );
        }

        // pack() the value, and gather information on it
        $packedValue = pack( $packFormat, $value );
        $maxIndex    = strlen( $packedValue ) - 1;
        $nullChar    = self::getNullChar();
        
        // Truncate or pad (with 0x00) the packed value to be N number of bytes long
        $byteString  = '';
        for ( $i = 0; $i < $byteSize; $i++ ) {
            if ( $i <= $maxIndex ) {
                $byteString .= $packedValue[ $i ];
            }
            else {
                $byteString .= $nullChar;
            }
        }
        return $byteString;
    }





    /*******************************************************************************************************************
    *                                                     INSTANCE FUNCTIONS
    *******************************************************************************************************************/


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
     * @return ByteArray
     */
    public function clone(): ICloneable
    {
        return ( clone $this );
    }


    /**
     * Retrieve the number of Bytes in this array
     */
    public function count(): int
    {
        return strlen( $this->__toString() );
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


    /**
     * Type-casts the ByteArray to an integer of architecture-dependent byte size
     */
    public function toInt(): int
    {
        $paddedBytes = str_pad( $this->bytes, 8, self::getNullChar() );
        return unpack( self::INT_FORMAT, $paddedBytes )[ 1 ];
    }





    /*******************************************************************************************************************
    *                                                     UTILITIES
    *******************************************************************************************************************/


    /**
     * Retrieve Null Character (0x00)
     * 
     * @return string
     */
    private static function getNullChar(): string
    {
        static $nullChar = null;
        if ( null === $nullChar ) {
            $nullChar =  pack( 'x' );
        }
        return $nullChar;
    }
}