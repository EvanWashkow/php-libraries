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
     * @throws MalformedEnumException If an Enum implementation defines non-string constants for its type
     */
    public function __construct( string $value )
    {
        parent::__construct( $value );
    }


    /**
     * Filter the value before it is set.
     * 
     * @param mixed $value The value to filter before setting.
     * @return string The value after filtering.
     * @throws \DomainException If the value is not supported
     */
    protected function filterValue( $value ): string
    {
        return parent::filterValue( $value );
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
