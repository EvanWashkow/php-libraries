<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\Dictionary;
use PHP\Enums\Exceptions\MalformedEnumException;
use PHP\ObjectClass;
use ReflectionClass;

/**
 * Allows users to define (and select from) a strict set of constant values.
 * 
 * All constants must be public. Any non-public constants will be ignored.
 * 
 * @internal Defaults must be defined and handled in the child class.
 */
abstract class Enum extends ObjectClass
{


    /*******************************************************************************************************************
    *                                               STATIC UTILITY METHODS
    *******************************************************************************************************************/


    /**
     * Returns the list of _public_ constants defined on this Enumeration class as name => value pairs
     * 
     * @return Dictionary
     * @throws MalformedEnumException If a constant is not public or does not match the Enum type restrictions
     */
    final public static function getConstants(): Dictionary
    {
        // Get properties about this class
        $thisClass      = new ReflectionClass( static::class );
        $isIntegerEnum  = $thisClass->isSubclassOf( IntegerEnum::class );
        $constantsArray = $thisClass->getReflectionConstants();

        // Create return value
        $constantsDictionary = new Dictionary( 'string', '*' );

        // For each constant in this class, verify its validity and add it to the dictionary
        foreach ( $constantsArray as $constant ) {
            if ( !$constant->isPublic() ) {
                throw new MalformedEnumException(
                    "All Enum constants should be public. {$thisClass->getName()}::{$constant->getName()} is not public."
                );
            }
            elseif ( $isIntegerEnum && !is_int( $constant->getValue() )) {
                throw new MalformedEnumException(
                    "All IntegerEnum constants must be integers. {$thisClass->getName()}::{$constant->getName()} is not an Integer."
                );
            }
            $constantsDictionary->set( $constant->getName(), $constant->getValue() );
        }

        // Return result
        return $constantsDictionary;
    }




    /*******************************************************************************************************************
    *                                                   PROPERTIES
    *******************************************************************************************************************/

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
     * Sanitizes the value before it is set by the constructor.
     * 
     * Returns the value if it is valid. Otherwise, it should throw a DomainException.
     * 
     * @param mixed $value The value to sanitize before setting.
     * @return mixed The value after sanitizing.
     * @throws \DomainException If the value is not supported
     */
    protected function sanitizeValue( $value )
    {
        if ( !self::getConstants()->hasValue( $value )) {
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
}
