<?php
namespace PHP\Types;

/**
 * Defines a mutable, unordered set of indexed values
 */
class Dictionary extends Object
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
