<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Enums\Enum;
use PHP\ObjectClass;
use PHP\Types\Models\ClassType;

/**
 * Retrieves information about an enumeration
 */
class EnumInfo extends ObjectClass
{

    /** @var ClassType $classType The Enum ClassType */
    private $classType;


    /**
     * Create information retrieval for an enumerated class
     * 
     * @param ClassType $enumClassType The Enum class type
     * @throws \DomainException If type is not an Enum
     */
    public function __construct( ClassType $enumClassType )
    {
        // Throw DomainException if the class type is not an Enum
        if ( !$enumClassType->is( Enum::class )) {
            throw new \DomainException(
                "Enum class expected. \"{$enumClassType->getName()}\" is not derived from the Enum class."
            );
        }

        // Set property
        $this->classType = $enumClassType;
    }


    /**
     * Retrieve the ClassType for the Enum instance
     * 
     * @return ClassType
     */
    private function getClassType(): ClassType
    {
        return $this->classType;
    }
}