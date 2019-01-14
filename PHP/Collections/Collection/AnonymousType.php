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


    /**
     * @see Type->equals()
     */
    public function equals( $item ): bool
    {
        return true;
    }


    /**
     * @see Type->is()
     */
    public function is( string $typeName ): bool
    {
        return true;
    }


    /**
     * @see Type->isClass()
     */
    public function isClass(): bool
    {
        throw new \TypeError( 'AnonymousType->isClass() is indeterminite.' );
    }


    /**
     * @see Type->isInterface()
     */
    public function isInterface(): bool
    {
        throw new \TypeError( 'AnonymousType->isInterface() is indeterminite.' );
    }
}
