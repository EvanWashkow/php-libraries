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
        return;
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