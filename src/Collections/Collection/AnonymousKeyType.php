<?php
declare( strict_types = 1 );

namespace PHP\Collections\Collection;

use PHP\Types\Models\AnonymousType;
use PHP\Types\Models\Type;

/**
 * Anonymous type for keys that evaluates to true for any type other than null
 */
class AnonymousKeyType extends AnonymousType
{


    public function equals( $item ): bool
    {
        $isEqual = true;
        if ( null === $item ) {
            $isEqual = false;
        }
        elseif ( is_a( $item, Type::class ) ) {
            $isEqual = !$item->is( 'null' );
        }
        return $isEqual;
    }


    public function is( string $typeName ): bool
    {
        return 'null' !== $typeName;
    }


    public function isValueOfType($value): bool
    {
        return ($value !== null);
    }
}
