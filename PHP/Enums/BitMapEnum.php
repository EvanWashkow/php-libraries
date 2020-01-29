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
     * @param mixed $value The bitmap value to sanitize before setting.
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
        if ( !$this->isSubset( $constantBitMap, $value )) {
            throw new \DomainException(
                'The value is not a Bit Map pair of the set of enumerated constants.'
            );
        }
        return $value;
    }


    /**
     * Determines if the given bits are set in the current value
     * 
     * @param int $bitMap The bits to check
     * @return bool
     */
    public function isSet( int $bitMap ): bool
    {
        return $this->isSubset( $this->getValue(), $bitMap );
    }


    /**
     * Determine if B is a bitwise subset of A
     * 
     * @param int $a The master bitmap to compare against
     * @param int $b The bitmap to be compared against $a
     * @return bool
     */
    private function isSubset( int $a, int $b ): bool
    {
        // If B is a subset of A, ANDing them together should produce B.
        return ( ( $a & $b ) === $b );
    }
}
