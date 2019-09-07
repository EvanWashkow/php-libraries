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
        // Convert any Enum instance into the class name
        if ( $enum instanceof Enum ) {
            $enum = get_class( $enum );
        }

        // Throw exception on invalid argument
        elseif ( !is_string( $enum ) ) {
            throw new \InvalidArgumentException(
                'Enum class name or instance expected. None given.'
            );
        }

        // Retrieve the enum info
        if ( !self::$cache->hasKey( $enum )) {
            try {
                $enumInfo = new EnumInfo( $enum );
                self::$cache->set( $enum, $enumInfo );
            } catch( NotFoundException $e ) {
                throw new NotFoundException( $e->getMessage() );
            } catch ( \DomainException $e ) {
                throw new \DomainException( $e->getMessage() );
            }
        }
        return self::$cache->get( $enum );;
    }
}
