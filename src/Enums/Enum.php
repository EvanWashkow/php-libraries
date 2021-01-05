<?php
declare(strict_types=1);

namespace PHP\Enums;

use PHP\Collections\ByteArray;
use PHP\Collections\ByteArrayConverter\SerializationByteArrayConverter;
use PHP\Collections\Dictionary;
use PHP\Enums\Exceptions\MalformedEnumException;
use PHP\Collections\ByteArrayConverter\PrimitiveValueByteArrayConverter;
use PHP\ObjectClass;
use PHP\Serialization\PHPSerialization;
use ReflectionClass;

/**
 * Allows users to define (and select from) a strict set of constant values.
 * 
 * All constants must be public.
 * 
 * @internal Defaults must be defined and handled in the child class.
 */
abstract class Enum extends ObjectClass
{


    /*******************************************************************************************************************
    *                                               STATIC UTILITY METHODS
    *******************************************************************************************************************/


    /**
     * Returns the list of public constants defined on this Enumeration class as name => value pairs
     * 
     * @return Dictionary
     * @throws MalformedEnumException If a constant is not public or does not match the Enum type restrictions
     */
    final public static function getConstants(): Dictionary
    {
        // Get properties about this class
        $thisClass      = new ReflectionClass( static::class );
        $isIntegerEnum  = $thisClass->isSubclassOf( IntegerEnum::class );
        $isStringEnum   = $thisClass->isSubclassOf( StringEnum::class );
        $constantsArray = $thisClass->getReflectionConstants();

        // Create return value
        $constantsDictionary = new Dictionary( 'string', '*' );

        // For each constant in this class, verify its validity and add it to the dictionary
        foreach ( $constantsArray as $constant )
        {
            // Get constant properties
            $constantName  = $constant->getName();
            $constantValue = $constant->getValue();

            // Verify the constants
            if ( !$constant->isPublic() ) {
                throw new MalformedEnumException(
                    "All Enum constants must be public. {$thisClass->getName()}::{$constantName} is not public."
                );
            }
            elseif ( $isIntegerEnum && !is_int( $constantValue )) {
                throw new MalformedEnumException(
                    "All IntegerEnum constants must be Integers. {$thisClass->getName()}::{$constantName} is not an Integer."
                );
            }
            elseif ( $isStringEnum && !is_string( $constantValue )) {
                throw new MalformedEnumException(
                    "All StringEnum constants must be Strings. {$thisClass->getName()}::{$constantName} is not a String."
                );
            }

            // Add (valid) constant to the dictionary
            $constantsDictionary->set( $constantName, $constantValue );
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
     * @throws MalformedEnumException If an Enum constant is not public
     **/
    public function __construct($value)
    {
        $this->value = $this->sanitizeValue($value);
    }


    /**
     * Sanitizes the value before it is set by the constructor.
     * 
     * Returns the value if it is valid. Otherwise, it should throw a DomainException.
     * 
     * @param mixed $value The value to sanitize before setting.
     * @return mixed The value after sanitizing.
     * @throws \DomainException If the value is not supported
     * @throws MalformedEnumException If an Enum constant is not public
     */
    protected function sanitizeValue( $value )
    {
        if ( !self::getConstants()->hasValue( $value )) {
            throw new \DomainException( 'The value is not in the set of enumerated constants.' );
        }
        return $value;
    }




    /*******************************************************************************************************************
    *                                                      MAIN
    *******************************************************************************************************************/


    /**
     * @internal If not a primitive value, this will serialize the value. This would possibly allow future
     * implementations to be equals() to array values, and would also allow them to be retrieved, thus, from Collections
     */
    public function hash(): ByteArray
    {
        static $converter = null;
        if ($converter === null ) {
            $converter = new PrimitiveValueByteArrayConverter(
                new SerializationByteArrayConverter(new PHPSerialization())
            );
        }
        return $converter->convert($this->getValue());
    }


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
     * @internal getValue() is not final so that Integer and String Enum can declare a return type.
     * setValue() is excluded by design. After an enum is set, it cannot be changed.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
