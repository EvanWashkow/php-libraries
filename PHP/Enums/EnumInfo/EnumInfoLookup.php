<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\Exceptions\NotFoundException;
use PHP\Types;
use PHP\Types\Models\ClassType;

/**
 * Lookup details about an enumerated class
 */
class EnumInfoLookup
{

    /** @var Dictionary $cache Previously looked-up enumerated classes */
    private static $cache = null;


    /**
     * Create a lookup routine for enumerated classes
     */
    public function __construct()
    {
        if ( null === self::$cache ) {
            self::$cache = new Dictionary( 'string', EnumInfo::class );
        }
    }


    /**
     * Retrieve information about an Enumerated class
     * 
     * @param string|Enum $enum The Enum class name or instance
     * @return EnumInfo
     * @throws NotFoundExeption If the type does not exist
     * @throws \DomainException If the type exists, but is not an Enum
     * @throws \InvalidArgumentException If argument is not a string or Enum instance
     */
    public function get( $enum ): EnumInfo
    {
        /**
         * Convert the argument into the enum class name, throwing an
         * Invalid Argument Exception if it is not a valid argument.
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
         * Build Enum Info if it is not cached
         */
        if ( !self::$cache->hasKey( $enumClassName ))
        {
            // The Enum's Type
            $enumType = null;

            // Try to get the enum type
            try {
                $enumType = Types::GetByName( $enumClassName );
            } catch ( NotFoundException $e ) {
                throw new NotFoundException( $e->getMessage(), $e->getCode() );
            }

            // Throw DomainException if the Type is not a ClassType
            if ( ! $enumType instanceof ClassType ) {
                throw new \DomainException(
                    "Enum class name expected. \"{$enumType->getName()}\" is not a class."
                );
            }

            // Throw DomainException if the ClassType is not derived from the
            // Enum class
            elseif ( ! $enumType->is( Enum::class )) {
                throw new \DomainException(
                    "Enum class name expected. \"{$enumType->getName()}\" is not derived from the Enum class."
                );
            }

            // Cache the Enum Info
            $enumInfo = $this->createEnumInfoByClassType( $enumType );
            self::$cache->set( $enumClassName, $enumInfo );
        }


        /**
         * Return the Enum Info
         */
        return self::$cache->get( $enumClassName );
    }


    /**
     * Create a new EnumInfo instance, by the Enum's class type
     * 
     * @param ClassType $enumClassType The Enum's ClassType instance
     * @return EnumInfo
     */
    protected function createEnumInfoByClassType( ClassType $enumClassType ): EnumInfo
    {
        if ( $enumClassType->is( Enum::class )) {
            $enumInfo = new EnumInfo( $enumClassType );
        }
        return $enumInfo;
    }
}
