<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Enums\Enum;
use PHP\Exceptions\NotFoundException;

/**
 * Lookup details about an enumerated class
 */
class EnumInfoLookup
{


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
        $enumInfo = null;
        if ( $enum instanceof Enum ) {
            $enumInfo = new EnumInfo( get_class( $enum ) );
        }
        elseif ( is_string( $enum ) ) {
            try {
                $enumInfo = new EnumInfo( $enum );
            } catch( NotFoundException $e ) {
                throw new NotFoundException( $e->getMessage() );
            } catch ( \DomainException $e ) {
                throw new \DomainException( $e->getMessage() );
            }
        }
        else {
            throw new \InvalidArgumentException(
                'Enum class name or instance expected. None given.'
            );
        }
        return $enumInfo;
    }
}
