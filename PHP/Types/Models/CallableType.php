<?php
namespace PHP\Types\Models;

use PHP\Types\TypeNames;

/**
 * Defines the base type for an item that can be invoked like a function
 */
class CallableType extends Type
{

    /** @var \ReflectionFunction $reflection Reflection of a callable instance */
    private $reflection;

    
    /**
     * Create a new instance of a callable type
     * 
     * @param string              $name       Type name (default is "callable")
     * @param string              $aliases    Alternate type names
     * @param \ReflectionFunction $reflection Reflection of a callable instance
     */
    public function __construct( string $name                    = '',
                                 array  $aliases                 = [],
                                 \ReflectionFunction $reflection = null )
    {
        // Set parent properies
        if ( '' === ( $name = trim( $name ) )) {
            $name = TypeNames::CALLABLE;
        }
        if ( !in_array( TypeNames::CALLABLE, $aliases )) {
            $aliases[] = TypeNames::CALLABLE;
        }
        parent::__construct( $name, $aliases );

        // Set own properties
        $this->reflection = ( null === $reflection )
            ? new \ReflectionFunction( function() {} )
            : $reflection;
    }


    /**
     * Fetch the reflection of a callable instance
     *
     * @return \ReflectionFunction
     **/
    final protected function getReflection(): \ReflectionFunction
    {
        return $this->reflection;
    }
}
