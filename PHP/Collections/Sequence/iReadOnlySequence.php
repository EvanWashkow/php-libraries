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
    
    /**
     * Retrieve the index for the last item
     *
     * @return int
     */
    public function GetFirstIndex(): int;
    
    /**
     * Retrieve the index for the last item
     *
     * @return int
     */
    public function GetLastIndex(): int;
    
    /**
     * Create a subset of items from this one
     *
     * @param int $start Starting index
     * @param int $end   Ending index
     * @return iReadOnlySequence
     */
    public function Slice( int $start, int $end ): iReadOnlySequence;
}
