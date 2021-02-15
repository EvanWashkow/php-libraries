<?php
declare( strict_types = 1 );

namespace PHP\Types\Models;

use PHP\Types\Models\Type;

/**
 * A "typeless type", where the compiler/interpreter infers the type from the value.
 * 
 * @internal Name cannot be a valid type name or possible function name.
 * Therefore, the name must be one that PHP does not allow. Also, '*' is pretty
 * descriptive of an anonymous type.
 * 
 * @internal Do not use as the base class for Type, even though PHP's default
 * behavior is anonymous typing. Under the hood, an anonymous type is
 * implemented using type inference, which uses strict typing.
 * 
 * @internal This is not available via Type lookup methods, for several reasons:
 * 1. It's not an actual type. Rather, it's a type container for actual types,
 * which, when queried, results in a non-anonymous type.
 * 2. Strict typing is much preferred: it's more secure and faster.
 * 3. However, it is useful when defining generics, like Collections.
 * 
 * @todo Once PHP defines a type name for anonymous types, modify this class
 * to use that name.
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


    public function is(string $typeName): bool
    {
        return true;
    }


    /**
     * Throws \BadMethodCallException
     * 
     * @throws \BadMethodCallException
     */
    public function isClass(): bool
    {
        throw new \BadMethodCallException( 'AnonymousType->isClass() is indeterminite.' );
    }


    /**
     * Throws \BadMethodCallException
     * 
     * @throws \BadMethodCallException
     */
    public function isInterface(): bool
    {
        throw new \BadMethodCallException( 'AnonymousType->isInterface() is indeterminite.' );
    }


    public function isValueOfType($value): bool
    {
        return true;
    }
}
