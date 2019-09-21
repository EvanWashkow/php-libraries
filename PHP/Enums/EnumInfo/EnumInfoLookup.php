<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\Exceptions\NotFoundException;
use PHP\Types;

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
        // Variables
        $enumClassName = '';
        $enumType      = null;

        /**
         * Convert the argument into the enum class name, throwing an
         * Invalid Argument Exception if it is not a valid argument.
         */
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

        // Try to get the enum type
        try {
            $enumType = Types::GetByName( $enumClassName );
        } catch ( NotFoundException $e ) {
            throw new NotFoundException( $e->getMessage(), $e->getCode() );
        }

        // Switch on enum type to create the desired enum info
        if ( $enumType->is( Enum::class )) {
            return new EnumInfo( $enumClassName );
        }
        else {
            throw new \DomainException(
                "Enum class name expected. \"$enumClassName\" is not an Enum."
            );
        }
    }
}
