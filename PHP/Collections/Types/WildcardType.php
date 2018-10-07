<?php
namespace PHP\Collections\Types;

use PHP\Types\Type;

/**
 * Type wildcard that evaluates to true for any type
 */
final class WildcardType extends Type
{


    /**
     * Create a wildcard type which always evaluates to true for any type
     */
    public function __construct()
    {
        parent::__construct( '*' );
    }


    public function equals( $item ): bool
    {
        return true;
    }


    public function is( string $typeName ): bool
    {
        return true;
    }
}
