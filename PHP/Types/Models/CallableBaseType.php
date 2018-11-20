<?php
namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Defines the base type for an item that can be invoked like a function
 */
class CallableBaseType extends Type implements ICallableType
{
    

    public function __construct( string $name = '', array $aliases = [] )
    {
        if ( '' === ( $name = trim( $name ) )) {
            $name = TypeNames::CALLABLE;
        }
        if ( !in_array( TypeNames::CALLABLE, $aliases )) {
            $aliases[] = TypeNames::CALLABLE;
        }
        parent::__construct( $name, $aliases );
    }
}
