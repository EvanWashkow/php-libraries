<?php
namespace PHP\Collections;

use PHP\Collections\Collection\ReadOnlyCollectionSpec;

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
    
    
    public function Add( $index, $value )
    {
        if ( $this->HasIndex( $index )) {
            trigger_error( "Cannot add entry since one already exists at the index \"{$index}\"" );
            $index = null;
        }
        else {
            $index = $this->insert( $index, $value );
        }
        return $index;
    }
    
    
    public function Clear()
    {
        $this->entries = [];
    }
    
    
    public function Clone(): ReadOnlyCollectionSpec
    {
        $clone = new static( $this->indexType, $this->valueType );
        $this->Loop( function( $index, $value, &$clone ) {
            $clone->Add( $index, $value );
        }, $clone );
        return $clone;
    }
    
    
    public function ConvertToArray(): array
    {
        return $this->entries;
    }
    
    
    public function Count(): int
    {
        return count( $this->entries );
    }
    
    
    public function Get( $index, $defaultValue = null )
    {
        $value = $defaultValue;
        if ( $this->HasIndex( $index )) {
            $value = $this->entries[ $index ];
        }
        return $value;
    }
    
    
    public function HasIndex( $index ): bool
    {
        return (
            $this->isValidIndexType( $index ) &&
            array_key_exists( $index, $this->entries )
        );
    }
    
    
    public function Loop( callable $function, &...$args )
    {
        $iterable   = new Iterable( $this->entries );
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $iterable, 'Loop' ], $parameters );
    }
    
    
    public function Remove( $index )
    {
        unset( $this->entries[ $index ] );
    }
    
    
    public function Update( $index, $value )
    {
        if ( $this->HasIndex( $index )) {
            $this->insert( $index, $value );
        }
        else {
            trigger_error( "There is no entry at the index \"{$index}\" to update" );
            $index = null;
        }
        return $index;
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
     * Store the value at the specified index
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure.
     */
    private function insert( $index, $value )
    {
        if ( !$this->isValidIndexType( $index )) {
            trigger_error( "The index \"{$index}\" does not match its type constraints" );
            $index = null;
        }
        elseif (( '' !== $this->valueType ) && !is( $value, $this->valueType )) {
            trigger_error( 'The value does not match its type constraints' );
            $index = null;
        }
        else {
            $this->entries[ $index ] = $value;
        }
        return $index;
    }
}
