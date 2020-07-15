<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use DomainException;
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
 * @method void __construct( Byte[] $bytes )                            Create a new Byte Array using the bytes of the given Byte[]
 * @method void __construct( double $bytes, int $byteSize = PHP_INT_SIZE ) Create a new Byte Array using the bytes of the given double-precision floating point number
 * @method void __construct( int $bytes, int $byteSize = PHP_INT_SIZE ) Create a new Byte Array using the bytes of the given integer
 * @method void __construct( string $bytes )                            Create a new Byte Array using the bytes of the given string
 */
class ByteArray extends ObjectClass implements IArrayable, ICloneable, IIntegerable, IReadOnlyCollection, IStringable
{


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
        if ( is_array( $bytes )) {
            try {
                $this->__constructByteArray( ...$bytes );
            } catch ( \TypeError $te ) {
                throw new \InvalidArgumentException( 'ByteArray->__construct() expecting a Byte[]. An element in the array was not a Byte.' );
            }
        }
        elseif ( is_float( $bytes )) {
            $args = func_get_args();
            try {
                $this->__constructDouble( ...$args );
            } catch ( \DomainException $de ) {
                throw new \DomainException( $de->getMessage(), $de->getCode(), $de );
            }
        }
        elseif ( is_int( $bytes )) {
            $args = func_get_args();
            try {
                $this->__constructInt( ...$args );
            } catch ( \DomainException $de ) {
                throw new \DomainException( $de->getMessage(), $de->getCode(), $de );
            }
        }
        elseif ( is_string( $bytes )) {
            $this->__constructString( $bytes );
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
            $byteString .= $this->packInt( $byte->toInt(), 1 );
        }
        $this->__constructString( $byteString );
    }


    /**
     * Create a new Byte Array instance using the bytes of the given floating point number
     * 
     * @param float $bytes    The floating point number representing the bytes
     * @param int   $byteSize Forces the resulting byte array to be N number of bytes long, from 0 to X bytes long,
     * truncating bytes or padding with 0x00 as necessary.
     * padding with 0x00 as necessary.
     * @return void
     * @throws \DomainException If the Byte Size is less than 0
     * 
     * @link https://www.php.net/manual/en/reserved.constants.php#constant.php-int-size
     */
    private function __constructDouble( float $bytes, int $byteSize = PHP_INT_SIZE ): void
    {
        $byteString = pack( 'd', $bytes );
        try {
            $byteString = $this->fixStringLength( $byteString, $byteSize );
        } catch ( \DomainException $de ) {
            throw new \DomainException( $de->getMessage(), $de->getCode(), $de );
        }
        $this->__constructString( $byteString );
    }


    /**
     * Create a new Byte Array instance using the bytes of the given integer
     * 
     * @param int $bytes    The integer representing the bytes
     * @param int $byteSize Forces the resulting byte array to be N number of bytes long, from 0 to X bytes long,
     * truncating bytes or padding with 0x00 as necessary.
     * @return void
     * @throws \DomainException If the Byte Size is less than 0
     * 
     * @link https://www.php.net/manual/en/reserved.constants.php#constant.php-int-size
     */
    private function __constructInt( int $bytes, int $byteSize = PHP_INT_SIZE ): void
    {
        try {
            $byteString = $this->packInt( $bytes, $byteSize );
        } catch ( \DomainException $de ) {
            throw new \DomainException( $de->getMessage(), $de->getCode(), $de );
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
     * Converts an integer to its string equivalent
     * 
     * @param int $bytes    The integer representing the bytes
     * @param int $byteSize Forces the resulting byte array to be N number of bytes long, from 0 to X bytes long,
     * truncating bytes or padding with 0x00 as necessary.
     * 
     * @return string The string typecast of the integer
     * 
     * @throws \DomainException If the Byte Size < 0
     */
    private function packInt( int $int, int $byteSize ): string
    {
        // pack() integer as 64-bit string, and then set it to a fixed length
        $packedInt = pack( 'Q', $int );
        try {
            return $this->fixStringLength( $packedInt, $byteSize );
        } catch ( \DomainException $de ) {
            throw new DomainException( $de->getMessage(), $de->getCode(), $de );
        }
    }


    /**
     * Truncates / Pads a byte string to be X number of bytes long
     * 
     * @param string $bytes    The string representing the bytes
     * @param int    $byteSize Forces the resulting byte array to be N number of bytes long, from 0 to X bytes long,
     * truncating bytes or padding with 0x00 as necessary.
     * 
     * @return string The string typecast of the integer
     * 
     * @throws \DomainException If the Byte Size < 0
     */
    private function fixStringLength( string $bytes, int $byteSize ): string
    {
        // Ensure Byte Size range is valid
        if ( $byteSize < 0 ) {
            throw new \DomainException( 'Byte Size cannot be less than 0.' );
        }

        // Variables
        $maxIndex = strlen( $bytes ) - 1;
        $nullChar = self::getNullChar();    // 0x00 character-equivalent
        
        // Treat the integer as N number of bytes long, truncating extra bytes or padding with zeros as necessary.
        $byteString  = '';
        for ( $i = 0; $i < $byteSize; $i++ ) {
            if ( $i <= $maxIndex ) {
                $byteString .= $bytes[ $i ];
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
        return unpack( 'Q', $paddedBytes )[ 1 ];
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