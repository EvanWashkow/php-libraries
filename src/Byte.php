<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Exceptions\NotImplementedException;
use PHP\Interfaces\IIntegerable;
use PHP\Interfaces\IStringable;

/**
 * Defines an 8-bit Byte
 */
class Byte extends ObjectClass implements IIntegerable, IStringable
{


    /**
     * Creates a new Byte instance
     * 
     * @param int|string $byte The Byte, represented in the form of either an integer or character
     */
    public function __construct( $byte )
    {
        if ( is_int( $byte )) {
            if (( $byte < 0 ) || ( 255 < $byte )) {
                throw new \RangeException( 'Byte integer value must be between 0 and 255.' );
            }
        }
        elseif ( !is_string( $byte )) {
            throw new \InvalidArgumentException( 'Byte value must be an integer or string.' );
        }
    }


    public function __toString(): string
    {
        throw new NotImplementedException( 'Not implemented, yet.' );
    }


    public function toInt(): int
    {
        throw new NotImplementedException( 'Not implemented, yet.' );
    }
}