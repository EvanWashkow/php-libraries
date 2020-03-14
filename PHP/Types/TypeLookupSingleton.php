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
     */
    public static function getInstance(): self
    {
        return new self();
    }


    /**
     * Private: only 
     */
    private function __construct()
    {
        return;
    }
}