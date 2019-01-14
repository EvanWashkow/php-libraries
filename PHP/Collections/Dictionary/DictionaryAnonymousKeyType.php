<?php
declare( strict_types = 1 );

namespace PHP\Collections\Dictionary;

use PHP\Types\Models\Type;
use PHP\Collections\Collection\AnonymousKeyType;

/**
 * Anonymous type for dictionary keys that returns true for ints and strings
 */
class DictionaryAnonymousKeyType extends AnonymousKeyType
{


    public function equals( $item ): bool
    {
        return (
            
            // Check value
            ( is_int( $item ) || is_string( $item ) ) ||

            // Check type
            (
                is_a( $item, Type::class ) &&
                (
                    $item->is( 'int' ) ||
                    $item->is( 'string' )
                )
            )
        );
    }


    public function is( string $typeName ): bool
    {
        return in_array( $typeName, [ 'int', 'string' ], true );
    }
}
