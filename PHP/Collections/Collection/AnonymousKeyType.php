<?php
namespace PHP\Collections\Collection;

/**
 * Anonymous type for keys that evaluates to true for any type other than null
 */
class AnonymousKeyType extends AnonymousType
{


    public function equals( $item ): bool
    {
        // Get the item type
        $type = \PHP\Types::GetByValue( $item );

        // The item is a Type instance. Evaluate the item as the Type.
        if ( $type->is( \PHP\Types\Models\Type::class )) {
            $type = $item;
        }
        
        // Return true as long as the type is not null
        return !$type->is( 'null' );
    }


    public function is( string $typeName ): bool
    {
        return 'null' !== $typeName;
    }
}
