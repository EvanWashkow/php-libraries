<?php
declare(strict_types=1);

namespace PHP\Enums;

/**
 * Defines a set of bit maps, allowing the user to specify one or more of them in a bitwise OR (|) operation.
 * 
 * All constants must be public and integers.
 */
abstract class BitMapEnum extends IntegerEnum
{


    /**
     * Sanitizes the value before it is set by the constructor.
     * 
     * Returns the value if it is valid. Otherwise, it should throw a DomainException.
     * 
     * @param mixed $value The value to sanitize before setting.
     * @return int The value after sanitizing.
     * @throws \DomainException If the value is not supported
     * @throws MalformedEnumException If an Enum constant is not public or not an integer
     */
    protected function sanitizeValue( $value ): int
    {
        $constantBitMap = 0;
        foreach ( self::getConstants()->toArray() as $constantValue ) {
            $constantBitMap = $constantBitMap | $constantValue;
        }
        if ( 0 === ( $constantBitMap & $value )) {
            throw new \DomainException(
                'The value is not a Bit Map pair of the set of enumerated constants.'
            );
        }
        return $value;
    }


    /**
     * Returns true if **all** the bits in the given bit map are set. False otherwise.
     * 
     * @param int $bitMap The bits to check
     * @return bool
     */
    public function isSet( int $bitMap ): bool
    {
        /**
         * If all the bits in the given bitmap are set on the current value, then ANDing the two together will result in
         * the originally-given bitmap. Otherwise, if the given bitmap has one bit that is not set, then ANDing the two
         * together will result in a different result than the orignal bitmap.
         */
        return ( ( $this->getValue() & $bitMap ) === $bitMap );
    }
}
