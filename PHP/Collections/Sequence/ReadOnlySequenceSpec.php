<?php
namespace PHP\Collections\Sequence;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;

/**
 * Specifications for a read-only, ordered set of indexed values
 */
interface ReadOnlySequenceSpec extends ReadOnlyCollectionSpec
{
    
    /**
     * Create a new enumerated instance
     *
     * @param string $type Establishes type requirement for all values. See `is()`.
     */
    public function __construct( string $type = '' );
    
    /**
     * Retrieve the index for the last entry
     *
     * @return int
     */
    public function GetFirstIndex(): int;
    
    /**
     * Retrieve the index for the last entry
     *
     * @return int
     */
    public function GetLastIndex(): int;
    
    /**
     * Search and retrieve index for the first instance of the specified value
     *
     * @param mixed $value           Value to get the index for
     * @param int   $offset          Start search from this index
     * @param bool  $isReverseSearch Start search from the end, offsetting as necessary from the end of the list.
     * @return int The index of the value, or -1
     */
    public function GetIndexOf( $value, int $offset = 0, bool $isReverseSearch = false ): int;
    
    /**
     * Create a subset of entries from this one
     *
     * @param int $start Starting index
     * @param int $end   Ending index
     * @return ReadOnlySequenceSpec
     */
    public function Slice( int $start, int $end ): ReadOnlySequenceSpec;
    
    /**
     * Chop these entries into groups, using the given value as a delimiter
     *
     * @param mixed $delimiter Value separating each group
     * @param int   $limit     Maximum number of entries to return; negative to return all.
     * @return ReadOnlySequenceSpec
     */
    public function Split( $delimiter, int $limit = -1 ): ReadOnlySequenceSpec;
}
