<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;
use PHP\Enums\Exceptions\MalformedEnumException;

/**
 * Allows users to define (and select from) a strict set of constant integers
 */
abstract class IntegerEnum extends Enum
{


    /*******************************************************************************************************************
    *                                                 CONSTRUCTOR METHODS
    *******************************************************************************************************************/


    /**
     * Create a new Enumeration integer instance
     * 
     * @param int $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     * @throws MalformedEnumException If an Enum implementation defines non-integer constants for its type
     */
    public function __construct( int $value )
    {
        // Throw Malformed Enum Exception if non-integer constants are defined
        foreach ( $this->getConstants() as $constantName => $value ) {
            if ( !is_int( $value )) {
                $class = static::class;
                throw new MalformedEnumException(
                    "IntegerEnum constants must be Integers. {$class}::{$constantName} is not an Integer."
                );
            }
        }

        parent::__construct( $value );
    }


    /**
     * Sanitizes the value before it is set by the constructor.
     * 
     * Returns the value if it is valid. Otherwise, it should throw a DomainException.
     * 
     * @param mixed $value The value to sanitize before setting.
     * @return int The value after sanitizing.
     * @throws \DomainException If the value is not supported
     */
    protected function sanitizeValue( $value ): int
    {
        return parent::sanitizeValue( $value );
    }




    /*******************************************************************************************************************
    *                                                        MAIN
    *******************************************************************************************************************/


    /**
     * @see parent::getValue()
     * 
     * @internal Final: the returned value cannot be modified. It is the direct
     * result of other underlying methods.
     * 
     * @return int
     */
    final public function getValue(): int
    {
        return parent::getValue();
    }
}
