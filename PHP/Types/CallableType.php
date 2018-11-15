<?php
namespace PHP\Types;

/**
 * Defines the base type for an item that can be invoked like a function
 */
class CallableType extends Type
{
    

    public function __construct( string $name = '', array $aliases = [] )
    {
        if ( '' === ( $name = trim( $name ) )) {
            $name = TypeNames::CALLABLE_TYPE_NAME;
        }
        if ( !in_array( TypeNames::CALLABLE_TYPE_NAME, $aliases )) {
            $aliases[] = TypeNames::CALLABLE_TYPE_NAME;
        }
        parent::__construct( $name, $aliases );
    }
}
