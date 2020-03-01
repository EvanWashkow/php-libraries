<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Exceptions\NotFoundException;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookup;

/**
 * @deprecated 2020-02-29
 */
trigger_error( '\\PHP\\Types is deprecated. Use \\PHP\\Types\\TypeLookup instead.', E_USER_DEPRECATED );

/**
 * Deprecated
 * 
 * @deprecated 2020-02-29
 */
final class Types
{


    /**
     * Deprecated
     * 
     * @deprecated 2020-02-29
     */
    public static function GetByName( string $name ): Type
    {
        trigger_error(
            '\\PHP\\Types::GetByName() is deprecated. Use \\PHP\\Types\\TypeLookup->getByName() instead.',
            E_USER_DEPRECATED
        );
        try {
            $type = ( new TypeLookup() )->getByName( $name );
        } catch ( \DomainException $de ) {
            throw new NotFoundException( $de->getMessage() );
        }
        return $type;
    }


    /**
     * Deprecated
     * 
     * @deprecated 2020-02-29
     */
    public static function GetByValue( $value ): Type
    {
        trigger_error(
            '\\PHP\\Types::GetByValue() is deprecated. Use \\PHP\\Types\\TypeLookup->getByValue() instead.',
            E_USER_DEPRECATED
        );
        return ( new TypeLookup() )->getByValue( $value );
    }
}
