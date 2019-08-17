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
     * Create a new instance to retrieve information on an enumerated class
     * 
     * @param string|Enum $enum The Enum class name or an Enum instance
     * @throws \InvalidArgumentException When not given an Enum name or instance.
     * @throws NotFoundException If the type does not exist.
     * @throws DomainException   If the type does exist, but is not an Enum.
     */
    public function __construct( $enum )
    {
        // Variables
        $this->classType = null;

        // Try to get the class type
        if ( $enum instanceof Enum ) {
            $this->classType = Types::GetByValue( $enum );
        }
        elseif ( is_string( $enum )) {
            try {
                $this->classType = Types::GetByName( $enum );
            } catch ( NotFoundException $e ) {
                throw new NotFoundException( $e->getMessage() );
            }
        }
        else {
            throw new \InvalidArgumentException(
                'Enum or Enum class name expected. None given.'
            );
        }

        // Throw exception on non-enum type
        if ( !$this->getClassType()->is( Enum::class ) ) {
            $typeName = $this->getClassType()->getName();
            throw new DomainException(
                "Enum name or instance expected. None given. \"$typeName\" is not an instance of an Enum."
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