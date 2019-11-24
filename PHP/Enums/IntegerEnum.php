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
     */
    public function __construct( int $value )
    {
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
     * @return int
     */
    final public function getValue(): int
    {
        return parent::getValue();
    }
}
