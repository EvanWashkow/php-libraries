<?php
namespace PHP\Collections\Sequence;

use PHP\Object\iObject;

/**
 * Define the type for a read-only, ordered set of indexed values
 */
interface iReadOnlySequence extends iObject
{
    
    /**
     * Create a new enumerated instance
     *
     * @param string $type Establishes type requirement for all items. See `is()`.
     */
    public function __construct( string $type = '' );
}
