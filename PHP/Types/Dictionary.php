<?php
namespace PHP\Types;

/**
 * Defines a mutable, unordered set of indexed values
 */
class Dictionary extends _IndexedValues
{
    
    /**
     * The set of indexed values
     *
     * @var array
     */
    private $items;
    
    /**
     * Specifies the type requirement for all indexes
     *
     * @var string
     */
    private $indexType;
    
    /**
     * Specifies the type requirement for all values
     *
     * @var string
     */
    private $valueType;
    
    
    /**
     * Create a new Dictionary instance
     *
     * @param string $indexType Specifies the type requirement for all indexes (see `is()`). An empty string permits all types.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $indexType = '', string $valueType = '' )
    {
        // Abort. Neither index nor value can be null.
        if ( 'null' === strtolower( $indexType )) {
            throw new \Exception( 'Dictionary indexes cannot be NULL' );
        }
        elseif ( 'null' === strtolower( $valueType )) {
            throw new \Exception( 'Dictionary values cannot be NULL' );
        }
        
        // Initialize properties
        $this->Clear();
        $this->indexType = $indexType;
        $this->valueType = $valueType;
    }
    
    
    /**
     * Store the value at the specified index
     *
     * Fails if the index already exists or if the index or value doesn't match
     * its type requirement.
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure.
     */
    public function Add( $index, $value )
    {
        if ( $this->HasIndex( $index )) {
            $index = null;
        }
        else {
            $index = $this->Update( $index, $value );
        }
        return $index;
    }
    
    
    /**
     * Remove all stored items
     */
    public function Clear()
    {
        $this->items = [];
    }
    
    
    /**
     * Convert to a PHP-native array
     *
     * @return array
     */
    public function ConvertToArray(): array
    {
        return $this->items;
    }
    
    
    /**
     * Count all items, returning the result
     *
     * @return int
     */
    public function Count(): int
    {
        return count( $this->items );
    }
    
    
    /**
     * Retrieve the value stored at the specified index
     *
     * @param mixed $index        The index to retrieve the value from
     * @param mixed $defaultValue The value to return if the index does not exist
     * @return mixed The value if the index exists. The default value otherwise.
     */
    public function Get( $index, $defaultValue = null )
    {
        $value = $defaultValue;
        if ( $this->HasIndex( $index )) {
            $value = $this->items[ $index ];
        }
        return $value;
    }
    
    
    /**
     * Determine if the index exists
     *
     * @param mixed $index The index to check
     * @return bool
     */
    public function HasIndex( $index ): bool
    {
        return (
            is( $index, $this->indexType ) &&
            array_key_exists( $index, $this->items )
        );
    }
    
    
    /**
     * Iterate through every item, invoking the callback function with the
     * item's index and value
     *
     * To exit the loop early, return a non-NULL value. This value will also be
     * returned by Loop().
     *
     * Additional arguments can be passed to the callback function by adding
     * them to Loop(), after the callback function definition. To make edits to
     * them in the callback function, use the reference identifier `&`.
     *
     * @param callable $function Callback function to execute for each item
     * @param mixed    ...$args  Additional arguments to be passed to the callback function (can be edited by the reference identifier `&` in the callback function)
     * @return mixed   NULL or the value returned by the callback function
     */
    public function Loop( callable $function, &...$args )
    {
        foreach ( $this->items as $index => $value ) {
            
            // Add index and value the callback function parameters
            $parameters = array_merge(
                [
                    $index,
                    $value
                ],
                $args
            );
            
            // Execute the callback function, exiting when a non-null value is returned
            $result = call_user_func_array( $function, $parameters );
            if ( null !== $result ) {
                return $result;
            }
        }
    }
    
    
    /**
     * Remove the value from the index
     *
     * @param mixed $index The index to remove the value from
     */
    public function Remove( $index )
    {
        if ( $this->HasIndex( $index )) {
            unset( $this->items[ $index ] );
        }
    }
    
    
    /**
     * Store the value at the index, overwriting any pre-existing values
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure.
     */
    public function Update( $index, $value )
    {
        if ( is( $index, $this->indexType ) && is( $value, $this->valueType )) {
            $this->items[ $index ] = $value;
        }
        else {
            $index = null;
        }
        return $index;
    }
}
