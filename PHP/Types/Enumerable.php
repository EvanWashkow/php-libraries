<?php
namespace PHP\Types;

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
     * Retrieve the index for the first entry with a matching value, or -1 if
     * the item could not be found.
     *
     * @param mixed $value  Value to get the index for
     * @param int   $offset Start search from this index
     * @return int
     */
    public function GetIndexOf( $value, int $offset = 0 ): int
    {
        // Variables
        $index = -1;
    
        // Error. Offset cannot be negative.
        if ( $offset < 0 ) {
            \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Offset cannot be negative.' );
        }
    
        // Find index for the value
        else {
            $array  = $this->Slice( $offset, $this->Count() - 1 )->ConvertToArray();
            $_index = array_search( $value, $array );
            if ( false !== $_index ) {
                $index = $_index + $offset;
            }
        }
    
        return $index;
    }
    
    
    /**
     * Creates a subset of items from the current items
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
     * Splits items around a particular value, grouping each set
     *
     * @param mixed $value Value to split this enumerable on
     * @param int   $limit Maximum number of items to return; negative to return all.
     * @return Enumerable
     */
    public function Split( $value, int $limit = -1 ): Enumerable
    {
        // Variables
        $groups = [];
        $group  = [];
        
        // For each entry, either add it to the group, or, if the value matches,
        // create a new group
        foreach ( $this->items as $item ) {
            if ( $limit === count( $groups )) {
                break;
            }
            elseif ( $value === $item ) {
                $groups[] = new static( $this->type, $group );
                $group    = [];
            }
            else {
                $group[] = $item;
            }
        }
        
        // Add the last, non-empty group to the groups list
        if ( 0 < count( $group )) {
            $groups[] = new static( $this->type, $group );
        }
        
        return new static( $this->GetType(), $groups );
    }
}
