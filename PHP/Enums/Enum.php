<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;
use PHP\ObjectClass;
use PHP\Types;

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

    /** @var Dictionary List of constants in this enumeration */
    private $constants;

    /** @var mixed $value The current value in this set of enumerated constants */
    private $value;




    /***************************************************************************
    *                              CONSTRUCTOR METHODS
    ***************************************************************************/


    /**
     * Create a new Enumeration instance
     *
     * @param mixed $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     **/
    public function __construct( $value )
    {
        $this->constants = $this->filterConstants(
            Types::GetByName( get_class( $this ) )->getConstants()
        );
        $this->value = $this->filterValue( $value );
    }


    /**
     * Return a new constants dictionary
     * 
     * @param Dictionary $constants This class's constants
     * @return Dictionary
     * @throws \DomainException On bad constant definitions
     */
    protected function filterConstants( Dictionary $constants ): Dictionary
    {
        return $constants;
    }


    /**
     * Filter the value before it is set.
     * 
     * @return mixed
     * @throws \DomainException If the value is not supported
     */
    protected function filterValue( $value )
    {
        if ( !$this->getConstants()->hasValue( $value )) {
            throw new \DomainException(
                'The value is not in the set of enumerated constants.'
            );
        }
        return $value;
    }




    /***************************************************************************
    *                                    MAIN
    ***************************************************************************/


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
     * Retrieve the list of constants for this class
     *
     * @return Dictionary
     **/
    protected function getConstants(): Dictionary
    {
        return $this->constants->clone();
    }
}
