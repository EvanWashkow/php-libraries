<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Enums\Exceptions\MalformedEnumException;

/**
 * Allows users to define (and select from) a strict set of constant strings
 */
abstract class StringEnum extends Enum
{


    /*******************************************************************************************************************
    *                                                 CONSTRUCTOR METHODS
    *******************************************************************************************************************/


    /**
     * Create a new Enumeration string instance
     * 
     * @param string $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     * @throws MalformedEnumException If an Enum implementation defines non-string constants for its type
     */
    public function __construct( string $value )
    {
        // Throw Malformed Enum Exception if non-string constants are defined
        foreach ( $this->getConstants() as $constantName => $value ) {
            if ( !is_string( $value )) {
                $class = static::class;
                throw new MalformedEnumException(
                    "StringEnum constants must be Strings. {$class}::{$constantName} is not an String."
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
     * @return string The value after sanitizing.
     * @throws \DomainException If the value is not supported
     */
    protected function sanitizeValue( $value ): string
    {
        return parent::sanitizeValue( $value );
    }




    /*******************************************************************************************************************
    *                                                         MAIN
    *******************************************************************************************************************/


    /**
     * @see parent::getValue()
     * 
     * @internal Final: the returned value cannot be modified. It is the direct
     * result of other underlying methods.
     * 
     * @return string
     */
    final public function getValue(): string
    {
        return parent::getValue();
    }
}
