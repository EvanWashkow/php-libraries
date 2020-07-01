<?php
declare( strict_types = 1 );

namespace PHP\Collections\Strings;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IStringable;
use PHP\ObjectClass;

/**
 * Defines a Hexadecimal String equivalent for the associated array of bytes
 */
class Hexadecimal extends ObjectClass implements IStringable
{

    /** @var ByteArray $byteArray The array of bytes to be converted into Hexadecimal */
    private $byteArray;


    /**
     * Create a new instance of a Hexadecimal String
     * 
     * @param ByteArray $byteArray The array of bytes to be converted into Hexadecimal
     * @return void
     */
    public function __construct( ByteArray $byteArray )
    {
        $this->byteArray = $byteArray;
    }


    public function __toString(): string
    {
        return bin2hex( $this->byteArray->__toString() );
    }
}
