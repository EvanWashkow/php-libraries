<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Collections\Dictionary;
use PHP\Enums\Enum;
use PHP\Exceptions\NotFoundException;

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
     * @throws \DomainException If the type is not an Enum
     * @throws \InvalidArgumentException If argument is not a string or Enum instance
     */
    public function get( $enum ): EnumInfo
    {
        // Get the enum class name
        $enumClassName = '';

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

        // Retrieve the enum info
        if ( !self::$cache->hasKey( $enumClassName )) {
            try {
                $enumInfo = new EnumInfo( $enumClassName );
                self::$cache->set( $enumClassName, $enumInfo );
            } catch( NotFoundException $e ) {
                throw new NotFoundException( $e->getMessage() );
            } catch ( \DomainException $e ) {
                throw new \DomainException( $e->getMessage() );
            }
        }
        return self::$cache->get( $enumClassName );
    }
}
