<?php
namespace PHP\Types;

/**
 * Defines a non-mutable list of values
 */
class Enumerable extends _Enumerable
{
    
    /**
     * Entries for this 
     *
     * @var array
     */
    protected $entries;
    
    /**
     * Defines type requirement for all entries
     *
     * @var string
     */
    protected $type;
    
    
    /**
     * Create a new enumerated instance
     *
     * @param string $type    Establishes type requirement for all entries. See `is()`.
     * @param array  $entries Values for this enumerable
     */
    public function __construct( string $type = '', array $entries = [] )
    {
        // For each entry, check it to make sure it is of the same type
        if ( '' !== $type ) {
            foreach ( $entries as $i => $entry ) {
                if ( !is( $entry, $type )) {
                    unset( $entries[ $i ] );
                }
            }
        }
        
        // Set entries, dropping non-numerical indexes
        $this->type    = $type;
        $this->entries = array_values( $entries );
    }
    
    
    public function Count(): int
    {
        return count( $this->entries );
    }
    
    
    public function ForEach( callable $function )
    {
        foreach ( $this->entries as $i => $entry ) {
            $result = call_user_func_array( $function, [ $entry, $i ] );
            if ( null !== $result ) {
                break;
            }
        }
    }
    
    
    public function Get( int $index )
    {
        $value = null;
        if ( array_key_exists( $index, $this->entries )) {
            $value = $this->entries[ $index ];
        }
        return $value;
    }
    
    
    public function Slice( int $start, int $end ): _Enumerable
    {
        // Variables
        $subset = [];
        
        // Error. Start index cannot be negative.
        if ( $start < 0 ) {
            \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Starting index cannot be negative.' );
        }
        
        // Error. Ending index cannot be less than the starting index.
        elseif ( $end < $start ) {
            \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Ending index cannot be smaller than the starting index.' );
        }
        
        // Create subset
        else {
            
            // Sanitize the ending index
            if ( $this->Count() <= $end ) {
                \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Ending index should not surpass the starting index.' );
                $end = $this->Count() - 1;
            }
            
            // For each entry in the index range, push them into the subset array
            for ( $i = $start; $i <= $end; $i++ ) {
                $subset[] = $this->entries[ $i ];
            }
        }
        
        return new static( $this->type, $subset );
    }
    
    
    public function IndexOf( $value, int $offset = 0 ): int
    {
        // Variables
        $index = -1;
        
        // Error. Offset cannot be negative.
        if ( $offset < 0 ) {
            \PHP\Debug\Log::Write( __CLASS__ . '->' . __FUNCTION__ . '() Offset cannot be negative.' );
        }
        
        // Find index for the value
        else {
            $array  = $this->Slice( $offset, $this->Count() - 1 )->ToArray();
            $_index = array_search( $value, $array );
            if ( false !== $_index ) {
                $index = $_index + $offset;
            }
        }
        
        return $index;
    }
    
    
    public function ToArray(): array
    {
        return $this->entries;
    }
}
