<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use DomainException;
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
     * @throws DomainException If string is not an Enum class name
     */
    public function __construct( string $enumClassName )
    {
        try {
            $this->classType = Types::GetByName( $enumClassName );
        } catch ( NotFoundException $e ) {
            throw DomainException(
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