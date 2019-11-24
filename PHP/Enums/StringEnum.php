<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;
use PHP\Enums\Exceptions\MalformedEnumException;

/**
 * Allows users to define (and select from) a strict set of constant strings
 */
abstract class StringEnum extends Enum
{


    /***************************************************************************
    *                              CONSTRUCTOR METHODS
    ***************************************************************************/


    /**
     * Create a new Enumeration string instance
     * 
     * @param string $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     */
    public function __construct( string $value )
    {
        // Throw Malformed Enum Exception if non-string constants are defined
        foreach ( self::GetConstants()->toArray() as $constantName => $value ) {
            if ( !is_string( $value )) {
                $class = static::class;
                throw new MalformedEnumException(
                    "StringEnum constants must be Strings. {$class}::{$constantName} is not an String."
                );
            }
        }

        parent::__construct( $value );
    }




    /***************************************************************************
    *                                    MAIN
    ***************************************************************************/


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
