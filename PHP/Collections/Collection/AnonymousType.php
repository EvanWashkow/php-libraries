<?php
declare( strict_types = 1 );

namespace PHP\Collections\Collection;

use PHP\Types\Models\Type;

/**
 * Type that evaluates to true for any type
 */
class AnonymousType extends Type
{

    /** @var string NAME Name for the anonymous type */
    const NAME = '*';


    /**
     * Create a type which always evaluates to true for any type
     */
    public function __construct()
    {
        parent::__construct( self::NAME );
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
