<?php
declare( strict_types = 1 );

namespace PHP\Types;

/**
 * Retrieves a singleton instance of the default Type Lookup implementation
 */
final class TypeLookupSingleton extends TypeLookup
{


    /**
     * Retrieve a singleton instance of the default Type Lookup implementation
     * 
     * @return self
     */
    public static function getInstance(): self
    {
        static $instance = null;
        if ( null === $instance ) {
            $instance = new self();
        }
        return $instance;
    }


    /**
     * Private: only 
     */
    private function __construct()
    {
        return;
    }
}