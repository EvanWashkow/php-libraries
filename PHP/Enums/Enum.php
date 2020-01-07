<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;
use PHP\ObjectClass;
use PHP\Types;
use ReflectionClass;

/**
 * Allows users to define (and select from) a strict set of constant values
 * 
 * @internal Defaults must be defined and handled in the child class.
 */
abstract class Enum extends ObjectClass
{


    /***************************************************************************
    *                                   PROPERTIES
    ***************************************************************************/

    /** @var mixed $value The current value in the set of enumerated constants */
    private $value;




    /*******************************************************************************************************************
    *                                                 CONSTRUCTOR METHODS
    *******************************************************************************************************************/


    /**
     * Create a new Enumeration instance
     *
     * @param mixed $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     **/
    public function __construct( $value )
    {
        $this->value = $this->sanitizeValue( $value );
    }


    /**
     * Filter the value before it is set.
     * 
     * @param mixed $value The value to filter before setting.
     * @return mixed The value after filtering.
     * @throws \DomainException If the value is not supported
     */
    protected function sanitizeValue( $value )
    {
        if ( !in_array( $value, $this->getConstants(), true )) {
            throw new \DomainException(
                'The value is not in the set of enumerated constants.'
            );
        }
        return $value;
    }




    /*******************************************************************************************************************
    *                                                      MAIN
    *******************************************************************************************************************/


    /**
     * Determine if the current value is equal to another Enum or value
     * 
     * @param mixed $value Enum instance or value to compare to
     * @return bool
     */
    public function equals( $value ): bool
    {
        if ( $value instanceof Enum ) {
            $value = $value->getValue();
        }
        return $this->getValue() === $value;
    }


    /**
     * Retrieve the current value
     * 
     * @internal setValue() is excluded by design. After an enum is set, it
     * cannot be changed.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Temporary: Retrieve constants for this Enumeration
     * 
     * @return array
     */
    final protected function getConstants(): array
    {
        return ( new ReflectionClass( $this ) )->getConstants();
    }
}
