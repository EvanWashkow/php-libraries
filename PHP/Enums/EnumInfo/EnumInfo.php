<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use DomainException;
use PHP\Enums\Enum;
use PHP\Exceptions\NotFoundException;
use PHP\Types;
use PHP\Types\Models\ClassType;

/**
 * Retrieves information about an enumeration
 */
class EnumInfo
{

    /** @var ClassType $classType The Enum ClassType */
    private $classType;


    /**
     * Create information retrieval for an enumerated class
     * 
     * @param string $enumClassName The Enum class name
     * @throws NotFoundExeption If the type does not exist
     * @throws \DomainException If type is not an Enum
     */
    public function __construct( string $enumClassName )
    {
        // Get the type, or fail if it can not be found
        try {
            $this->classType = Types::GetByName( $enumClassName );
        } catch ( NotFoundException $e ) {
            throw new NotFoundException(
                "Enum class name expected. \"$enumClassName\" is not a known type."
            );
        }

        // Fail if the class type is not an Enum
        if ( !$this->getClassType()->is( Enum::class )) {
            throw new \DomainException(
                "Enum class name expected. \"$enumClassName\" is not an Enum."
            );
        }
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