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

    /** @var ByteArray $byteArray The Byte Array */
    private $byteArray;

    /** @var string $string The Hexadecimal string */
    private $string;


    /**
     * Create a new instance of a Hexadecimal String
     * 
     * @param ByteArray $byteArray The array of bytes to be converted into Hexadecimal
     * @return void
     */
    public function __construct( ByteArray $byteArray )
    {
        $this->byteArray = $byteArray;
        $this->string = bin2hex( $byteArray->__toString() );
    }


    public function __toString(): string
    {
        return $this->string;
    }


    public function equals($value): bool
    {
        return (
            ($value instanceof Hexadecimal) &&
            ($this->__toString() === $value->__toString())
        );
    }


    protected function createHash(): ByteArray
    {
        return $this->byteArray;
    }
}
