<?php
namespace PHP\Collections;

/**
 * Defines a non-mutible set of items with integer indexes
 */
class Enumerable extends Iterable
{
    
    /**
     * Defines type requirement for all items
     *
     * @var string
     */
    protected $type;
    
    
    /**
     * Create a new enumerated instance
     *
     * @param string $type  Establishes type requirement for all items. See `is()`.
     * @param array  $items Values for this enumerable
     */
    public function __construct( string $type = '', array $items = [] )
    {
        // For each entry, check it to make sure it is of the same type
        if ( '' !== $type ) {
            foreach ( $items as $i => $item ) {
                if ( !is( $item, $type )) {
                    unset( $items[ $i ] );
                }
            }
        }
        
        // Set items, dropping non-numerical indexes
        $this->type = $type;
        parent::__construct( array_values( $items ));
    }
    
    
    /**
     * Retrieve the value from the corresponding index
     *
     * @param int $index Index to retrieve the value from
     * @return mixed Value or NULL if the index does not exist.
     */
    public function Get( int $index )
    {
        $value = null;
        if ( array_key_exists( $index, $this->items )) {
            $value = $this->items[ $index ];
        }
        return $value;
    }
    
    
    /**
     * Retrieve the index for the first item
     *
     * @return int
     */
    final public function GetFirstIndex(): int
    {
        return 0;
    }
    
    
    /**
     * Retrieve the index for the last item
     *
     * @return int
     */
    final public function GetLastIndex(): int
    {
        return $this->Count() - 1;
    }
    
    
    /**
     * Search items for a particular value, returning the index of the first one
     * found or -1 if none were found.
     *
     * @param mixed $value           Value to get the index for
     * @param int   $offset          Start search from this index
     * @param bool  $isReverseSearch Start search from the end, offsetting as necessary from the end of the list.
     * @return int
     */
    public function GetIndexOf( $value, int $offset = 0, bool $isReverseSearch = false ): int
    {
        // Variables
        $index = -1;
    
        // Exit. Offset cannot be negative.
        if ( $offset < 0 ) {
            \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Offset cannot be negative.' );
            return $index;
        }
            
        // Get the array, reversing it if performing a reverse search
        $array = $this->ConvertToArray();
        if ( $isReverseSearch ) {
            $array = array_reverse( $array );
        }
        
        // Get a subset of the array, starting at the offset
        $enumerable    = new self( $this->type, $array );
        $subEnumerable = $enumerable->Slice( $offset, $enumerable->GetLastIndex() );
        
        // Search the sub-array for the value
        $_index = array_search( $value, $subEnumerable->ConvertToArray() );
        if ( false !== $_index ) {
            
            // Invert index for reverse search. Keep in mind that the last
            // index is actually the first in the original order.
            if ( $isReverseSearch ) {
                $index = $subEnumerable->GetLastIndex() - $_index;
            }
            
            // Add the offset to forward searches
            else {
                $index = $_index + $offset;
            }
        }
    
        return $index;
    }
    
    
    /**
     * Create a subset of items from this one
     *
     * @param int $start Starting index
     * @param int $end   Ending index
     * @return Enumerable
     */
    public function Slice( int $start, int $end ): Enumerable
    {
        // Variables
        $subset = [];
        
        // Error. Ending index cannot be less than the starting index.
        if ( $end < $start ) {
            \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Ending index cannot be less than the starting index.' );
        }
        
        // Create subset
        else {
            
            // Sanitize the starting index
            if ( $start < $this->GetFirstIndex() ) {
                \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Starting index cannot be less than the first index of the item list.' );
                $start = $this->GetFirstIndex();
            }
            
            // Sanitize the ending index
            if ( $this->GetLastIndex() < $end ) {
                \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Ending index cannot surpass the last index of the item list.' );
                $end = $this->GetLastIndex();
            }
            
            // For each entry in the index range, push them into the subset array
            for ( $i = $start; $i <= $end; $i++ ) {
                $subset[] = $this->items[ $i ];
            }
        }
        
        return new static( $this->type, $subset );
    }
    
    
    /**
     * Chop these items into groups, using the given value as a delimiter
     *
     * @param mixed $delimiter Value to split this enumerable on
     * @param int   $limit     Maximum number of items to return; negative to return all.
     * @return Enumerable
     */
    public function Split( $delimiter, int $limit = -1 ): Enumerable
    {
        // Variables
        $start       = 0;
        $groups      = [];
        $canContinue = true;
        
        // While there are items left
        do {
            
            // Halt loop if the limit has been reached.
            if (( 0 <= $limit ) && ( $limit === count( $groups ))) {
                $canContinue = false;
            }
            
            else {
                
                // Get index of the next delimiter
                $end = $this->GetIndexOf( $delimiter, $start );
                
                // Delimiter not found. Set end as the last index.
                if ( $end < 0 ) {
                    $end = $this->GetLastIndex() + 1;
                    $canContinue = false;
                }
                
                // Group the items between the start and end, excluding the delimiter
                $group = $this->Slice( $start, $end - 1 );
                if ( 0 !== $group->Count() ) {
                    $groups[] = $group;
                }
                
                // Move start index.
                $start = $end + 1;
                
                // Halt loop if the last item was processed
                if ( $this->GetLastIndex() <= $start ) {
                    $canContinue = false;
                }
            }
        } while ( $canContinue );
        
        // Return item groups as an immutable list
        return new self( $this->GetType(), $groups );
    }
}
