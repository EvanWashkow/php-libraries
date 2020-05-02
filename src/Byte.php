<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Interfaces\IIntegerable;

/**
 * Defines an 8-bit Byte
 */
class Byte extends ObjectClass implements IIntegerable
{

    /** @var int $byte The Byte, represented as an integer */
    private $byte;


    /**
     * Creates a new Byte instance
     * 
     * @param int $byte The Byte, represented as an integer
     */
    public function __construct( int $byte )
    {
        if (( $byte < 0 ) || ( 255 < $byte )) {
            throw new \RangeException( "A Byte's integer value must be between 0 and 255." );
        }
        $this->byte = $byte;
    }


    /**
     * Determine if this Byte is equal to the given value
     * 
     * @param int|Byte $value The value to compare this Byte to 
     */
    public function equals( $value ): bool
    {
        return ( $value instanceof Byte )
            ? $this->toInt() === $value->toInt()
            : $this->toInt() === $value;
    }


    public function toInt(): int
    {
        return $this->byte;
    }
}