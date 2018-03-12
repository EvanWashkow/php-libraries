<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\iReadOnlyCollection;

/**
 * Define the type for a read-only, ordered set of indexed values
 */
interface iReadOnlySequence extends iReadOnlyCollection
{
    
    /**
     * Create a new enumerated instance
     *
     * @param string $type Establishes type requirement for all values. See `is()`.
     */
    public function __construct( string $type = '' );
}
