<?php
declare( strict_types = 1 );

namespace PHP;

use PHP\Exceptions\NotFoundException;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookup;

/**
 * Lookup type information
 * 
 * Callables are not types. They evaluate variables at runtime using reflection,
 * to determine if they reference a function. For example, 'substr' is callable,
 * but 'foobar' is not. Both are of the string type, but one is "callable" and
 * the other is not.
 */
final class Types
{


    /**
     * Retrieve the type information by name
     *
     * @param string $name The type name
     * @return Type
     * @throws NotFoundException
     */
    public static function GetByName( string $name ): Type
    {
        try {
            $type = ( new TypeLookup() )->getByName( $name );
        } catch ( \DomainException $de ) {
            throw new NotFoundException( $de->getMessage() );
        }
        return $type;
    }


    /**
     * Retrieve the type information by value
     *
     * @param mixed $value The value to retrieve type information for
     * @return Type
     */
    public static function GetByValue( $value ): Type
    {
        return ( new TypeLookup() )->getByValue( $value );
    }
}
