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


    /***************************************************************************
    *                              CONSTRUCTOR METHODS
    ***************************************************************************/


    /**
     * Create a new Enumeration integer instance
     * 
     * @param int $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     * @throws MalformedEnumException If an Enum implementation defines non-integer constants for its type
     */
    public function __construct( int $value )
    {
        parent::__construct( $value );
    }


    /**
     * Filter the value before it is set.
     * 
     * @param mixed $value The value to filter before setting.
     * @return int The value after filtering.
     * @throws \DomainException If the value is not supported
     */
    protected function filterValue( $value ): int
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
     * @return int
     */
    final public function getValue(): int
    {
        return parent::getValue();
    }
}
