<?php

declare(strict_types=1);

namespace PHP\Types;

/**
 * Retrieves a singleton instance of the default Type Lookup implementation.
 *
 * Marked as final. See README.md.
 */
final class TypeLookupSingleton extends TypeLookup
{
    /**
     * Private: only to be used by ::getInstance().
     */
    private function __construct()
    {
    }

    /**
     * Retrieve a singleton instance of the default Type Lookup implementation.
     */
    public static function getInstance(): self
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }
}
