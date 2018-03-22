<?php
namespace PHP\Collections;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;
use PHP\Collections\Sequence\ReadOnlySequence;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines a mutable, unordered set of indexed values
 */
class Dictionary extends \PHP\Object implements DictionarySpec
{
    
    /**
     * The set of indexed values
     *
     * @var array
     */
    private $entries;
    
    /**
     * Specifies the type requirement for all indices
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
     * @param string $indexType Specifies the type requirement for all indices (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $indexType = '', string $valueType = '' )
    {
        // Abort. The index type must be either an integer or string.
        if (( 'integer' !== $indexType ) && ( 'string' !== $indexType )) {
            throw new \Exception( 'Dictionary indices must either be integers or strings' );
        }
        
        // Abort. Value types cannot be null.
        elseif ( 'null' === strtolower( $valueType )) {
            throw new \Exception( 'Dictionary values cannot be NULL' );
        }
        
        
        // Initialize properties
        $this->clear();
        $this->indexType = $indexType;
        $this->valueType = $valueType;
    }
    
    
    public function add( $index, $value ): bool
    {
        $isSuccessful = false;
        if ( $this->hasIndex( $index )) {
            trigger_error( 'Cannot add value: index already exists' );
        }
        else {
            $isSuccessful = $this->set( $index, $value );
        }
        return $isSuccessful;
    }
    
    
    public function clear()
    {
        $this->entries = [];
    }
    
    
    public function clone(): ReadOnlyCollectionSpec
    {
        $clone = new static( $this->indexType, $this->valueType );
        $this->loop( function( $index, $value, &$clone ) {
            $clone->add( $index, $value );
        }, $clone );
        return $clone;
    }
    
    
    public function convertToArray(): array
    {
        return $this->entries;
    }
    
    
    public function count(): int
    {
        return count( $this->entries );
    }
    
    
    public function get( $index )
    {
        if ( !$this->isValidIndexType( $index )) {
            throw new \Exception( "Cannot get non-{$this->indexType} index" );
        }
        elseif ( !$this->hasIndex( $index )) {
            throw new \Exception( "Cannot get value at non-existing index" );
        }
        return $this->entries[ $index ];
    }
    
    
    public function getIndices(): ReadOnlySequenceSpec
    {
        $indices = new Sequence( $this->indexType );
        foreach ( array_keys( $this->entries ) as $index ) {
            $indices->add( $index );
        }
        return new ReadOnlySequence( $indices );
    }
    
    
    public function getValues(): ReadOnlySequenceSpec
    {
        $values = new Sequence( $this->valueType );
        $this->loop(function( $index, $value, &$values ) {
            $values->add( $value );
        }, $values );
        return new ReadOnlySequence( $values );
    }
    
    
    public function hasIndex( $index ): bool
    {
        return (
            $this->isValidIndexType( $index ) &&
            array_key_exists( $index, $this->entries )
        );
    }
    
    
    public function loop( callable $function, &...$args )
    {
        $iterable   = new Iterable( $this->entries );
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $iterable, 'loop' ], $parameters );
    }
    
    
    public function remove( $index ): bool
    {
        $isSuccessful = false;
        if ( !$this->isValidIndexType( $index )) {
            trigger_error( "Cannot remove entry with non-{$this->indexType} index" );
        }
        elseif ( !$this->hasIndex( $index )) {
            trigger_error( 'Cannot remove value from non-existing index' );
        }
        else {
            unset( $this->entries[ $index ] );
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
    
    
    public function update( $index, $value ): bool
    {
        $isSuccessful = false;
        if ( $this->hasIndex( $index )) {
            $isSuccessful = $this->set( $index, $value );
        }
        else {
            trigger_error( 'Cannot update value: the index does not exist' );
        }
        return $isSuccessful;
    }
    
    
    /**
     * Determine if the index type meets its type constraints
     *
     * @param mixed $index The index to check
     * @return bool
     */
    final protected function isValidIndexType( $index ): bool
    {
        return (( '' === $this->indexType ) || is( $index, $this->indexType ));
    }
    
    
    /**
     * Determine if the value type meets its type constraints
     *
     * @param mixed $value The value to check
     * @return bool
     */
    final protected function isValidValueType( $value ): bool
    {
        return (( '' === $this->valueType ) || is( $value, $this->valueType ));
    }
    
    
    /**
     * Store the value at the specified index
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return bool Whether or not the operation was successful
     */
    private function set( $index, $value ): bool
    {
        $isSuccessful = false;
        if ( !$this->isValidIndexType( $index )) {
            trigger_error( "Cannot set value at a non-{$this->indexType} index" );
        }
        elseif ( !$this->isValidValueType( $value )) {
            trigger_error( "Cannot set non-{$this->valueType} values" );
        }
        else {
            $this->entries[ $index ] = $value;
            $isSuccessful = true;
        }
        return $isSuccessful;
    }
}
