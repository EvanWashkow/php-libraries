<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Enums\Enum;
use PHP\Enums\StringEnum;
use PHP\Exceptions\NotFoundException;
use PHP\Types;
use PHP\Types\Models\ClassType;

/**
 * Lookup details about an enumerated class
 * 
 * @internal This does not leverage any caching since, at its heart, this based
 * on the Types lookup system, which is already cached.
 */
class EnumInfoLookup
{


    /**
     * Retrieve information about an Enumerated class
     * 
     * @internal This method standardizes and sanitizes the argument, throwing
     * Exceptions as necessary.
     * 
     * @param string|Enum $enum The Enum class name or instance
     * @return EnumInfo
     * @throws \InvalidArgumentException If argument is not a string or Enum instance
     * @throws NotFoundExeption If the type does not exist
     * @throws \DomainException If the type exists, but is not an Enum
     */
    public function get( $enum ): EnumInfo
    {
        /**
         * Convert the argument into the enum class name, throwing an
         * Invalid Argument Exception on an invalid argument.
         */

        // The enum class name
        $enumClassName = '';

        // Switch on type
        if ( $enum instanceof Enum ) {
            $enumClassName = get_class( $enum );
        }
        elseif ( is_string( $enum ) ) {
            $enumClassName = $enum;
        }
        else {
            throw new \InvalidArgumentException(
                'Enum class name or instance expected. None given.'
            );
        }


        /**
         * Check the Enum Type instance to ensure it is for an Enum class
         */

        // The Enum's Type
        $type = null;

        // Try to get the enum type
        try {
            $type = Types::GetByName( $enumClassName );
        } catch ( NotFoundException $e ) {
            throw new NotFoundException( $e->getMessage(), $e->getCode() );
        }

        // Throw DomainException if the type is not an Enum
        if ( ! $type->is( Enum::class ) ) {
            throw new \DomainException(
                "Enum expected. \"{$type->getName()}\" is not an Enum class derivative."
            );
        }


        /**
         * Return the Enum Info
         */
        return $this->createEnumInfoByClassType( $type );
    }


    /**
     * Create a new EnumInfo instance, by the Enum's ClassType
     * 
     * @internal Override this method if you want to return a custom EnumInfo
     * type. No exceptions should be thrown here, since the ClassType is already
     * ensured to be an Enum class.
     * 
     * @param ClassType $enumClassType The Enum's ClassType instance
     * @return EnumInfo
     */
    protected function createEnumInfoByClassType( ClassType $enumClassType ): EnumInfo
    {
        if ( $enumClassType->is( StringEnum::class )) {
            $enumInfo = new StringEnumInfo( $enumClassType );
        }
        elseif ( $enumClassType->is( Enum::class )) {
            $enumInfo = new EnumInfo( $enumClassType );
        }
        return $enumInfo;
    }
}
