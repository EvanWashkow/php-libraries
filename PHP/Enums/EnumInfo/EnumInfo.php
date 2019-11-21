<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\Enums\Exceptions\MalformedEnumException;
use PHP\ObjectClass;
use PHP\Types\Models\ClassType;

/**
 * Retrieves information about an enumeration
 */
class EnumInfo extends ObjectClass
{

    /*******************************************************************************************************************
    *                                                     PROPERTIES
    *******************************************************************************************************************/

    /** @var ClassType $classType The Enum ClassType */
    private $classType;




    /*******************************************************************************************************************
    *                                                     CONSTRUCTOR
    *******************************************************************************************************************/


    /**
     * Create information retrieval for an enumerated class
     * 
     * @param ClassType $enumClassType The Enum class type
     * @throws \DomainException        If type is not an Enum
     * @throws \MalformedEnumException If the Enum defines constants prohibited by the parent Enum type.
     */
    public function __construct( ClassType $enumClassType )
    {
        // Throw DomainException if the class type is not an Enum
        if ( !$enumClassType->is( Enum::class )) {
            throw new \DomainException(
                "Enum class expected. \"{$enumClassType->getName()}\" is not derived from the Enum class."
            );
        }

        // Set Enum ClassType instance
        $this->classType = $enumClassType;

        // Maybe throw MalformedEnumException if the Enum defines constants prohibited by the parent Enum type.
        $this->maybeThrowMalformedEnumException();
    }


    /**
     * Throws a MalformedEnumException if the Enum defines constants prohibited by the parent Enum type.
     * 
     * @throws MalformedEnumException
     */
    protected function maybeThrowMalformedEnumException(): void
    {
        return;
    }




    /*******************************************************************************************************************
    *                                                   PUBLIC ACCESSORS
    *******************************************************************************************************************/


    /**
     * Retrieve the constans for this Enum
     * 
     * @internal Override this method to filter the constants for this Enum type
     * 
     * @return Dictionary
     */
    public function getConstants(): Dictionary
    {
        return $this->getClassType()->getConstants();
    }




    /*******************************************************************************************************************
    *                                                  INTERNAL ACCESSORS
    *******************************************************************************************************************/


    /**
     * Retrieve the ClassType instance for this Enum Info
     * 
     * @return ClassType
     */
    final protected function getClassType(): ClassType
    {
        return $this->classType;
    }
}