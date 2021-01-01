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


    public function equals($value): bool
    {
        return (
            
            // Check value
            ( is_int( $value ) || is_string( $value ) ) ||

            // Check type
            (
                is_a( $value, Type::class ) &&
                (
                    $value->is( 'int' ) ||
                    $value->is( 'string' )
                )
            )
        );
    }


    public function is(string $typeName): bool
    {
        return in_array( $typeName, [ 'int', 'string' ], true );
    }


    public function isClass(): bool
    {
        return false;
    }


    public function isInterface(): bool
    {
        return false;
    }
}
}
