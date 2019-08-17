<?php
declare(strict_types=1);

namespace PHP\Enums\EnumInfo;

use PHP\Enums\Enum;

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
     * @throws \DomainException If string is not an Enum class name
     * @throws \InvalidArgumentException If argument is not a string or Enum instance
     */
    public function get( $enum ): EnumInfo
    {
        $enumInfo = null;
        if ( $enum instanceof Enum ) {
            $enumInfo = new EnumInfo( $enum::class );
        }
        elseif ( is_string( $enum ) ) {
            try {
                $enumInfo = new EnumInfo( $enum );
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
