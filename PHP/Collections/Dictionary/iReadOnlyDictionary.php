<?php
namespace PHP\Collections\Dictionary;

use PHP\Collections\iReadOnlyCollection;

/**
 * Define the type for a read-only, unordered set of indexed values
 */
interface iReadOnlyDictionary extends iReadOnlyCollection
{
    
    /**
     * Create a new Dictionary instance
     *
     * @param string $indexType Specifies the type requirement for all indexes (see `is()`). An empty string permits all types.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $indexType = '', string $valueType = '' );
}
