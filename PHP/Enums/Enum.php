<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;
use PHP\ObjectClass;

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
     * @throws \DomainException If the value is not in the set of enumerated constants
     **/
    public function __construct( $value )
    {
        // Set constants
        $this->constants = $this->__constructConstantsDictionary(
            ( new \ReflectionClass( $this ) )->getConstants()
        );

        // Set value
        $exception = $this->maybeGetValueException( $value );
        if ( null !== $exception ) {
            throw $exception;
        }
        $this->value = $value;
        return $this;
    }


    /**
     * Return a new constants dictionary
     * 
     * @param array $constants This class's array of constants
     * @throws \DomainException On bad constant definitions
     */
    protected function __constructConstantsDictionary( array $constants )
    {
        return new Dictionary( 'string', '*', $constants );
    }




    /***************************************************************************
    *                                VALUE ACCESSOR
    ***************************************************************************/


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
     * Retrieve Exception if there is something wrong with the given value
     * 
     * @return ?\Throwable
     */
    protected function maybeGetValueException( $value ): ?\Throwable
    {
        $exception = null;
        if ( !$this->getConstants()->hasValue( $value )) {
            $exception = new \DomainException(
                'The value is not in the set of enumerated constants.'
            );
        }
        return $exception;
    }




    /***************************************************************************
    *                                MISCELLANEOUS
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
     * Retrieve the list of constants for this class
     *
     * @return Dictionary
     **/
    protected function getConstants(): Dictionary
    {
        return $this->constants;
    }
}
